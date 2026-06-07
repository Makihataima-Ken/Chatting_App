# Chatting_App Frontend

This folder contains the Flutter client for the chat application.

The Flutter app connects to the Laravel backend and provides the mobile chat interface.

## Requirements

- Flutter SDK (compatible with Dart 3.3+)
- Platform toolchain for your target device(s): Android, iOS, web, Windows, macOS, or Linux

## Setup

From the `frontend/` folder:

```bash
cd frontend
flutter pub get
```

If the project uses code generation, run:

```bash
flutter pub run build_runner build --delete-conflicting-outputs
```

## Run the App

Launch the app on a connected device or simulator:

```bash
flutter run
```

To run on a specific device:

```bash
flutter run -d <device-id>
```

## Notes

- Make sure the app is configured to use the correct backend API URL.
- If you change model classes or JSON serialization, regenerate generated files using `build_runner`.

## License

This frontend is part of the Chatting_App project and is licensed under the MIT License.
