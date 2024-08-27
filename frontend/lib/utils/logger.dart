import 'package:logger/logger.dart';

final prettyLog = Logger(
    printer: PrettyPrinter(
  methodCount: 1,
  errorMethodCount: 8,
  lineLength: 120,
  colors: true,
  printEmojis: true,
  printTime: true,
));

final wlog = prettyLog.w;
final vlog = prettyLog.v;
final dlog = prettyLog.d;
final ilog = prettyLog.i;
final elog = prettyLog.e;
final wtflog = prettyLog.wtf;
