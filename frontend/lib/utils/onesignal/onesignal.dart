import 'package:frontend/utils/utils.dart';
import 'package:onesignal_flutter/onesignal_flutter.dart';

const oneSignalAppId = "a20d8fcd-c94f-47d8-8838-2051afa60221";

Future<void> initOneSignal() async {
  final oneSignalShared = OneSignal.shared;

  oneSignalShared.setLogLevel(OSLogLevel.verbose, OSLogLevel.none);

  oneSignalShared.setRequiresUserPrivacyConsent(true);

  await oneSignalShared.setAppId(oneSignalAppId);
}

registerOneSignalEventListener({
  required Function(OSNotificationOpenedResult) onOpened,
  required Function(OSNotificationReceivedEvent) onReceivedInForeground,
}) {
  final oneSignalShared = OneSignal.shared;

  oneSignalShared.setNotificationOpenedHandler(onOpened);

  oneSignalShared
      .setNotificationWillShowInForegroundHandler(onReceivedInForeground);
}

const tagName = "userId";

sendUserTag(int userId) {
  OneSignal.shared.sendTag(tagName, userId.toString()).then((response) {
    vlog("Successfully sent tags with response: $response");
  }).catchError((error) {
    vlog("Encountered an error sending tags: $error");
  });
}

deleteUserTag() {
  OneSignal.shared.deleteTag(tagName).then((response) {
    vlog("Successfully deleted tags with response $response");
  }).catchError((error) {
    vlog("Encountered error deleting tag: $error");
  });
}
