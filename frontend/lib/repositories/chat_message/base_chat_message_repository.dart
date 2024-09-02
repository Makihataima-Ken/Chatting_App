import 'package:frontend/models/models.dart';
import 'package:frontend/models/requests/requests.dart';

abstract class BaseChatMessageRepository {
  Future<AppResponse<List<ChatMessageEntity>>> getChatMessages({
    required int chatId,
    required int page,
  });

  Future<AppResponse<ChatMessageEntity?>> createChatMessage(
      CreateChatMessageRequest request, String socketId);
}
