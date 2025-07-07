import 'package:flutter/cupertino.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';

class NotificationService extends ChangeNotifier{

  final FlutterLocalNotificationsPlugin _flutterLocalNotificationsPlugin =
      FlutterLocalNotificationsPlugin();

  Future initialize() async {
    FlutterLocalNotificationsPlugin flutterLocalNotificationsPlugin = FlutterLocalNotificationsPlugin();

    AndroidInitializationSettings androidInitializationSettings =
        const AndroidInitializationSettings("@drawer/ic_launcher");

    final InitializationSettings initializationSettings =
        InitializationSettings(
          android: androidInitializationSettings
        );

    await flutterLocalNotificationsPlugin.initialize(initializationSettings);

  }

  // Instant Notification
  Future instantNotification(String channelID, String MessageDesc ) async{
    var description = "descripton";
    var andriod = AndroidNotificationDetails("id", channelID);

    var platform = new NotificationDetails(android: andriod);
    
    await _flutterLocalNotificationsPlugin.show(0, "Medicine Intake Alert", MessageDesc,platform,
    payload: "Welcome to Demo App"
    );
  }


}
