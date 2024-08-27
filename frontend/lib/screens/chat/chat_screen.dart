import 'package:dash_chat_2/dash_chat_2.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:frontend/blocs/chat/chat_bloc.dart';
import 'package:frontend/screens/chat/data.dart';
import 'package:frontend/utils/logger.dart';
import 'package:frontend/widgets/widgets.dart';

class ChatScreen extends StatefulWidget {
  const ChatScreen({super.key});
  static const routeName = "chat";

  @override
  State<ChatScreen> createState() => _ChatScreenState();
}

class _ChatScreenState extends State<ChatScreen> {
  List<ChatMessage> messages = basicSample;

  @override
  Widget build(BuildContext context) {
    return StartUpContainer(
      onInit: (){
        
      },
      child: Scaffold(
        appBar: AppBar(
          title: BlocConsumer<ChatBloc, ChatState>(
            listener: (_, __) {
              // TODO: implement listener
            },
            builder: (context, state) {
              final chat = state.selectedChat;
              return const Text("The Other User");
            },
          ),
        ),
        body: DashChat(
          currentUser: user,
          onSend: (ChatMessage chatMessage) {
            vlog("add a new message to the chat");
          },
          messages: messages,
          messageListOptions: MessageListOptions(
            onLoadEarlier: () async {
              await Future.delayed(const Duration(seconds: 3));
            },
          ),
        ),
      ),
    );
  }
}
