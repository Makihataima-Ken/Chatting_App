import 'package:dio/dio.dart';
import 'package:frontend/utils/dio_client/app_interceptors.dart';
class DioClient {
  static DioClient? _singleton;

  static late Dio _dio;

  DioClient._() {
    _dio = createDioClient();
  }

  factory DioClient() {
    return _singleton ??= DioClient._();
  }

  Dio get instance => _dio;

  Dio createDioClient() {
    final dio = Dio(BaseOptions(
      baseUrl: "http://10.0.2.2:8000",
      receiveTimeout: 15000,
      connectTimeout: 15000,
      sendTimeout: 15000,
      headers: {
        Headers.acceptHeader: 'application/json',
        Headers.contentTypeHeader: 'application/json'
      },
    ));

    dio.interceptors.addAll([
      // PrettyDioLogger(
      //   requestHeader: true,
      //   requestBody: true,
      //   responseBody: true,
      //   responseHeader: true,
      //   error: true,
      //   compact: true,
      //   maxWidth: 90,
      // ),
      AppInterceptors(),
    ]);

    return dio;
  }
}
