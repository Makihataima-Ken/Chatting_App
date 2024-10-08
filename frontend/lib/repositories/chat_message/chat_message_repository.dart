import 'package:dio/dio.dart';
import 'package:frontend/models/app_response.dart';
import 'package:frontend/models/chat_message_model.dart';
import 'package:frontend/models/requests/create_chat_message_request.dart';
import 'package:frontend/repositories/chat_message/base_chat_message_repository.dart';
import 'package:frontend/repositories/core/endpoints.dart';
import 'package:frontend/utils/dio_client/dio_client.dart';

class ChatMessageRepository extends BaseChatMessageRepository {
  final Dio _dioClient;

  ChatMessageRepository({
    Dio? dioClient,
  }) : _dioClient = dioClient ?? DioClient().instance;

  @override
  Future<AppResponse<ChatMessageEntity?>> createChatMessage(
      CreateChatMessageRequest request, String socketId) async {
    final response = await _dioClient.post(
      Endpoints.createChatMessage,
      data: request.toJson(),
      options: Options(
        headers: {
          'X-Socket-ID': socketId,
        },
      ),
    );

    return AppResponse<ChatMessageEntity?>.fromJson(
        response.data,
        (dynamic json) => response.data['success'] && json != null
            ? ChatMessageEntity.fromJson(json)
            : null);
  }

  @override
  Future<AppResponse<List<ChatMessageEntity>>> getChatMessages(
      {required int chatId, required int page}) async {
    final response =
        await _dioClient.get(Endpoints.getChatMessages, queryParameters: {
      'page': page,
      'chat_id': chatId,
    });

    return AppResponse<List<ChatMessageEntity>>.fromJson(
        response.data,
        (dynamic json) => response.data['success'] && json != null
            ? (json as List<dynamic>)
                .map((e) => ChatMessageEntity.fromJson(e))
                .toList()
            : []);
  }
}
