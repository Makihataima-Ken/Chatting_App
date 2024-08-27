import 'package:frontend/models/models.dart';

abstract class BaseUserRepository {
  Future<AppResponse<List<UserEntity>>> getUsers();
}
