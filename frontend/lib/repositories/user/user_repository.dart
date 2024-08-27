import 'package:dio/dio.dart';
import 'package:frontend/models/app_response.dart';
import 'package:frontend/models/user_model.dart';
import 'package:frontend/repositories/core/endpoints.dart';
import 'package:frontend/repositories/user/base_user_repository.dart';
import 'package:frontend/utils/utils.dart';

class UserRepository extends BaseUserRepository {
  final Dio _dioClient;

  UserRepository({
    Dio? dioClient,
  }) : _dioClient = dioClient ?? DioClient().instance;

  @override
  Future<AppResponse<List<UserEntity>>> getUsers() async {
    final response = await _dioClient.get(Endpoints.getUsers);

    return AppResponse<List<UserEntity>>.fromJson(response.data,
        (dynamic json) {
      if (response.data['success'] && json != null) {
        return (json as List<dynamic>)
            .map((e) => UserEntity.fromJson(e))
            .toList();
      }
      return [];
    });
  }
}
