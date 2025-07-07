import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../constants.dart';
import 'package:awesome_snackbar_content/awesome_snackbar_content.dart';
import 'package:http/http.dart' as http;
import 'package:intl/intl.dart';

import 'ForgetPassword.dart';
import 'home.dart';
import 'LoginWithMobile.dart';

class applicationNew extends StatefulWidget {
  const applicationNew({Key? key}) : super(key: key);

  @override
  State<applicationNew> createState() => _applicationNewState();
}

class _applicationNewState extends State<applicationNew> {
  final GlobalKey<ScaffoldState> _scaffoldKey = new GlobalKey<ScaffoldState>();

  TextEditingController user = TextEditingController();
  TextEditingController pass = TextEditingController();

  String patientID = " ";
  String data = "";
  late List listres = [];

  Future login() async {
    var url = Uri.parse("http://10.0.2.2/finalproject/admin/mobile-app-scripts/login-check.php");
    var response = await http.post(url, body: {
      "username": user.text,
      "password": pass.text,
    });
    if (response.statusCode == 200) {

      listres = jsonDecode(response.body);


      if (listres[0]['status'] == true) {
        var snackBar = SnackBar(
          elevation: 0,
          behavior: SnackBarBehavior.floating,
          backgroundColor: Colors.transparent,
          content: AwesomeSnackbarContent(
            title: 'Login Successful',
            message: 'Login has been successfully made so continue with the system',
            contentType: ContentType.success,
          ),
        );
        ScaffoldMessenger.of(context).showSnackBar(snackBar);
        print(listres[0]['patient'].toString());

        // Creating Session
        final SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
        sharedPreferences.setString('patientID', listres[0]['patient'].toString());

        // Redirecting to Home
        Navigator.push(context, MaterialPageRoute(builder: (context) => myHome()));

      } else if (listres[0]['status'] == false) {

        var snackBar1 = SnackBar(
          elevation: 0,
          behavior: SnackBarBehavior.floating,
          backgroundColor: Colors.transparent,
          content: AwesomeSnackbarContent(
            title: 'Login Failed',
            message: listres[0]['message'].toString(),
            contentType: ContentType.failure,
          ),
        );
        ScaffoldMessenger.of(context).showSnackBar(snackBar1);

        return Fluttertoast.showToast(
            msg: "Internal Server Error ${response.statusCode} - ${listres[0]['message']} ",
            toastLength: Toast.LENGTH_SHORT,
            gravity: ToastGravity.CENTER,
            timeInSecForIosWeb: 1,
            textColor: Colors.red,
            fontSize: 16.0
        );

        // Redirecting to same page
        Navigator.push(context, MaterialPageRoute(builder: (context) => applicationNew()));

      } else {
        var snackBar2 = SnackBar(
          elevation: 0,
          behavior: SnackBarBehavior.floating,
          backgroundColor: Colors.transparent,
          content: AwesomeSnackbarContent(
            title: 'Login Failed',
            message: listres[0]['message'].toString(),
            contentType: ContentType.failure,
          ),
        );
        ScaffoldMessenger.of(context).showSnackBar(snackBar2);

        return Fluttertoast.showToast(
            msg: "Internal Server Error ${response.statusCode} - ${listres[0]['message']} ",
            toastLength: Toast.LENGTH_SHORT,
            gravity: ToastGravity.CENTER,
            timeInSecForIosWeb: 1,
            textColor: Colors.red,
            fontSize: 16.0
        );

        // Redirecting to same page
        Navigator.push(context, MaterialPageRoute(builder: (context) => applicationNew()));

      };
    }
  }

  @override
  Widget build(BuildContext context) {

    return MaterialApp(
      theme: ThemeData(fontFamily: 'Lato'),
      debugShowCheckedModeBanner: false,
      home: Scaffold(
        key: _scaffoldKey,
        backgroundColor: Color.fromRGBO(236, 241, 250, 1.0),
        resizeToAvoidBottomInset: false,
        body: SafeArea(
          child: Center(
            child: Stack(
              children: [
                SingleChildScrollView(
                  child: Container(
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      crossAxisAlignment: CrossAxisAlignment.center,
                      children: <Widget>[
                        Container(
                          margin: EdgeInsets.fromLTRB(50, 0, 50, 0),
                          child: Image.asset('images/logo.png'),
                        ),
                        Container(
                          padding: EdgeInsets.all(16.0),
                          child: Column(
                            children: [
                              const Text("Welcome",
                                  style: TextStyle(fontSize: 30.0, color: appThemeColor, fontWeight: FontWeight.bold)),
                              const SizedBox(height: 10),
                              const Text("Sign into Continue"),
                              Padding(
                                padding: EdgeInsets.fromLTRB(0, 20, 0, 10),
                                child: TextField(
                                  controller: user,
                                  decoration: const InputDecoration(
                                    prefixIcon: Icon(Icons.alternate_email),
                                    border: OutlineInputBorder(),
                                    labelText: 'Username',
                                  ),
                                ),
                              ),
                              Padding(
                                padding: const EdgeInsets.fromLTRB(0, 0, 0, 10),
                                child: TextField(
                                  controller: pass,
                                  obscureText: true,
                                  decoration: const InputDecoration(
                                    prefixIcon: Icon(Icons.lock),
                                    border: OutlineInputBorder(),
                                    labelText: 'Password',
                                  ),
                                ),
                              ),
                              Container(
                                height: 50,
                                width: 300,
                                decoration:
                                    BoxDecoration(color: appThemeColor, borderRadius: BorderRadius.circular(10)),
                                child: TextButton(
                                  onPressed: () {
                                    login();
                                  },
                                  child: const Text(
                                    'Login',
                                    style: TextStyle(color: Colors.white, fontSize: 15, fontWeight: FontWeight.bold),
                                  ),
                                ),
                              ),
                              Container(
                                margin: const EdgeInsets.fromLTRB(0, 10, 0, 0),
                                height: 45,
                                width: 300,
                                decoration: BoxDecoration(borderRadius: BorderRadius.circular(10)),
                                child: OutlinedButton(
                                    onPressed: () {
                                      Navigator.push(
                                          context, MaterialPageRoute(builder: (context) => const GetMobileNumber()));
                                    },
                                    style: OutlinedButton.styleFrom(
                                      side: BorderSide(color: appThemeColor, width: 2),
                                    ),
                                    child: const Text(
                                      'Login with Mobile Number',
                                      style: TextStyle(color: appThemeColor, fontWeight: FontWeight.bold),
                                    )),
                              ),
                              Container(
                                height: 50,
                                width: 300,
                                alignment: Alignment.centerRight,
                                child: TextButton(
                                  onPressed: () {
                                    Navigator.push(
                                        context, MaterialPageRoute(builder: (context) => const GetPhoneNo()));
                                  },
                                  child: const Text(
                                    'Forgot Password',
                                    style: TextStyle(color: Colors.blue, fontSize: 15),
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),
                )
              ],
            ),
          ),
        ),
      ),
    );
  }
}

/*void initState() {
    apicall();
    super.initState();
  }*/
