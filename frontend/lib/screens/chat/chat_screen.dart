import 'dart:convert';

import 'package:dash_chat_2/dash_chat_2.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:frontend/blocs/auth/auth_bloc.dart';
import 'package:frontend/blocs/chat/chat_bloc.dart';
import 'package:frontend/models/chat_message_model.dart';
import 'package:frontend/models/chat_model.dart';
import 'package:frontend/utils/utils.dart';
import 'package:frontend/widgets/widgets.dart';
import 'package:pusher_client/pusher_client.dart';

class ChatScreen extends StatefulWidget {
  const ChatScreen({super.key});
  static const routeName = "chat";

  @override
  State<ChatScreen> createState() => _ChatScreenState();
}

class _ChatScreenState extends State<ChatScreen> {
  void listenChatChannel(ChatEntity chat) {
    LaravelEcho.instance.private('chat.${chat.id}').listen('.message.sent',
        (e) {
      if (e is PusherEvent) {
        if (e.data != null) {
          vlog(jsonDecode(e.data!));
          _handleNewMessage(jsonDecode(e.data!));
        }
      }
    }).error((err) {
      elog(err);
    });
  }

  void leaveChatChannel(ChatEntity chat) {
    try {
      LaravelEcho.instance.leave('chat.${chat.id}');
    } catch (err) {
      elog(err);
    }
  }

  void _handleNewMessage(Map<String, dynamic> data) {
    final chatBloc = context.read<ChatBloc>();
    final selectedChat = chatBloc.state.selectedChat!;
    if (selectedChat.id == data['chat_id']) {
      final chatMessage = ChatMessageEntity.fromJson(data['message']);
      chatBloc.add(AddNewMessage(chatMessage));
    }
  }

  @override
  Widget build(BuildContext context) {
    final chatBloc = context.read<ChatBloc>();
    final authBloc = context.read<AuthBloc>();

    return StartUpContainer(
      onInit: () {
        chatBloc.add(const GetChatMessage());
        if (chatBloc.state.selectedChat != null) {
          listenChatChannel(chatBloc.state.selectedChat!);
        }
      },
      onDisposed: () {
        leaveChatChannel(chatBloc.state.selectedChat!);
        chatBloc.add(const ChatReset());
        chatBloc.add(const ChatStarted());
      },
      child: Scaffold(
        appBar: AppBar(
          title: BlocConsumer<ChatBloc, ChatState>(
            listener: (context, state) {
              if (state.selectedChat != null) {
                listenChatChannel(state.selectedChat!);
              }
            },
            listenWhen: (previous, current) =>
                previous.selectedChat != current.selectedChat,
            builder: (context, state) {
              final chat = state.selectedChat;
              return Text(chat == null
                  ? "N/A"
                  : getChatName(chat.participants, authBloc.state.user!));
            },
          ),
        ),
        body: BlocBuilder<ChatBloc, ChatState>(
          builder: (context, state) {
            return DashChat(
              currentUser: authBloc.state.user!.toChatUser,
              onSend: (ChatMessage chatMessage) {
                chatBloc.add(
                  SendMessage(
                    state.selectedChat!.id,
                    chatMessage,
                    socketId: LaravelEcho.socketId,
                  ),
                );
              },
              messages: state.uiChatMessages,
              messageListOptions: MessageListOptions(
                onLoadEarlier: () async {
                  chatBloc.add(const LoadMoreChatMessage());
                },
              ),
            );
          },
        ),
      ),
    );
  }
}
