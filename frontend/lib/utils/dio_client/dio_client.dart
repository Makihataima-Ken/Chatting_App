import 'package:dio/dio.dart';
import 'package:frontend/utils/dio_client/app_interceptors.dart';
import 'package:pretty_dio_logger/pretty_dio_logger.dart';

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
      AppInterceptors(),
      PrettyDioLogger(
        requestHeader: true,
        requestBody: true,
        responseBody: true,
        responseHeader: true,
        error: true,
        compact: true,
        maxWidth: 90,
      ),
    ]);

    return dio;
  }
}
