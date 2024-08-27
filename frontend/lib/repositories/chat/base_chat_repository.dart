import 'package:frontend/models/models.dart';
import 'package:frontend/models/requests/requests.dart';

abstract class BaseChatRepository {
  Future<AppResponse<List<ChatEntity>>> getChats();

  Future<AppResponse<ChatEntity?>> createChat(CreateChatRequest request);

  Future<AppResponse<ChatEntity?>> getSingleChat(int chatId);
}
