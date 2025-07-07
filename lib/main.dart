import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:smart_hrms_app/services/notification.dart';
import 'constants.dart';
import 'Screens/userNameLogin.dart';
import 'Screens/introScreen.dart';
import 'Screens/home.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MultiProvider(
        child: MaterialApp(
          home: Scaffold(
              backgroundColor: Color.fromRGBO(236, 241, 250, 1),
              /*backgroundColor: appBgDefault,*/
              body: IntroductionScreens()
          ),
          debugShowCheckedModeBanner: false,
        ),
        providers: [ChangeNotifierProvider(create: (_) => NotificationService())]
    );
  }
}


class MyApp1 extends StatelessWidget {
  const MyApp1({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
        home: Scaffold(
          backgroundColor: appBgDefault,
          body: SafeArea(
            child: Column(
              children: [
                /*Image.asset("images/logo.png"),*/
                Expanded(child:  MediaQuery( data: new MediaQueryData(), child: IntroductionScreens()))
              ],
            )
          )
        )

    );
  }
}
