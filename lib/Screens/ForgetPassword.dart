import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../constants.dart';
import 'package:awesome_snackbar_content/awesome_snackbar_content.dart';
import 'package:http/http.dart' as http;
import 'package:intl/intl.dart';
import 'package:intl_phone_field/intl_phone_field.dart';

import 'home.dart';

class GetPhoneNo extends StatefulWidget {
  const GetPhoneNo({Key? key}) : super(key: key);

  @override
  State<GetPhoneNo> createState() => _GetPhoneNoState();
}

class _GetPhoneNoState extends State<GetPhoneNo> {
  final GlobalKey<ScaffoldState> _scaffoldKey = new GlobalKey<ScaffoldState>();

  TextEditingController user = TextEditingController();
  TextEditingController pass = TextEditingController();

  String data = "";
  late Map mapres;
  late List listres = [];

  Future login() async {
    var url = Uri.parse("http://10.0.2.2/finalproject/admin/mobile-app-scripts/login-check.php");
    var response = await http.post(url, body: {
      "username": user.text,
      "password": pass.text,
    });
    if (response.statusCode == 200) {
      listres = jsonDecode(response.body);
      // listres = mapres['data'];
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
        final SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
        sharedPreferences.setString('patientID', listres[0]['patient'].toString());
        Navigator.push(context, MaterialPageRoute(builder: (context) => myHome()));
      } else if(listres[0]['status'] == false){
        print("Error");
        var snackBar = SnackBar(
          elevation: 0,
          behavior: SnackBarBehavior.floating,
          backgroundColor: Colors.transparent,
          content: AwesomeSnackbarContent(
            title: 'Login Failed',
            message: listres[0]['message'].toString(),
            contentType: ContentType.failure,
          ),
        );
        ScaffoldMessenger.of(context).showSnackBar(snackBar);
      } else{
        var snackBar = SnackBar(
          elevation: 0,
          behavior: SnackBarBehavior.floating,
          backgroundColor: Colors.transparent,
          content: AwesomeSnackbarContent(
            title: 'Login Failed',
            message: listres[0]['message'].toString(),
            contentType: ContentType.failure,
          ),
        );
        ScaffoldMessenger.of(context).showSnackBar(snackBar);
      };
    }
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      theme: ThemeData(fontFamily: 'Lato'),
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
                              const Text("Forget Password",
                                  style: TextStyle(fontSize: 30.0, color: appThemeColor, fontWeight: FontWeight.bold)),
                              const SizedBox(height: 10),
                              const Text("All your accounts with us will be resetted and passwords will sent your phone",textAlign: TextAlign.center,),
                              Padding(
                                padding: EdgeInsets.fromLTRB(0, 20, 0, 10),
                                child: IntlPhoneField(
                                  decoration: InputDecoration(
                                    labelText: 'Phone Number',
                                    border: OutlineInputBorder(
                                      borderSide: BorderSide(),
                                    ),
                                  ),
                                  initialCountryCode: 'LK',
                                  onChanged: (phone) {
                                    print(phone.completeNumber);
                                  },
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
                                    'Reset Passwords',
                                    style: TextStyle(color: Colors.white, fontSize: 15, fontWeight: FontWeight.bold),
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
