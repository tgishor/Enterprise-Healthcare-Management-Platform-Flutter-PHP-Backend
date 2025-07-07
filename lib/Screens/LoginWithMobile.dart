import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:pinput/pinput.dart';
import 'package:intl_phone_field/intl_phone_field.dart';

import 'package:http/http.dart' as http;
import 'package:fluttertoast/fluttertoast.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../constants.dart';
import 'home.dart';

class GetMobileNumber extends StatefulWidget {
  const GetMobileNumber({Key? key}) : super(key: key);

  @override
  State<GetMobileNumber> createState() => _GetMobileNumberState();
}

class _GetMobileNumberState extends State<GetMobileNumber> {
  TextEditingController username = TextEditingController();
  TextEditingController mobileNumber = TextEditingController();
  bool _validate = false;


  @override
  void dispose() {
    username.dispose();
    mobileNumber.dispose();
    super.dispose();
  }


  String data = "";
  late Map mapres;
  late List listres = [];

  Future sentOTP() async {
    var url = Uri.parse("http://10.0.2.2/finalproject/admin/mobile-app-scripts/sent-otp-login.php");
    var response = await http.post(url, body: {
      "username": username.text,
      "mobilenumber": mobileNumber.text,
    });
    listres = jsonDecode(response.body);
    if (response.statusCode == 200) {
      if (listres[0]['status'] == true) {
        Navigator.push(context, MaterialPageRoute(builder: (context) =>
            LoginWithMobileNumber(pUsername: username.text, pMobile: mobileNumber.text)));
      }
    }else{
      return Fluttertoast.showToast(
          msg: "Internal Server Error ${response.statusCode} - ${listres[0]['message']} ",
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.CENTER,
          timeInSecForIosWeb: 1,
          textColor: Colors.red,
          fontSize: 16.0
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      theme: ThemeData(fontFamily: 'Lato'),
      home: Scaffold(
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
                              const Text("Login with Mobile Number",
                                  style: TextStyle(fontSize: 25.0, color: appThemeColor, fontWeight: FontWeight.bold)),
                              const SizedBox(height: 10),
                              const Text(
                                "Please enter you registered mobile and the username of the account you want to login ",
                                textAlign: TextAlign.center,
                              ),
                              Padding(
                                padding: const EdgeInsets.fromLTRB(0, 20, 0, 0),
                                child: TextField(
                                  controller: username,
                                  decoration: InputDecoration(
                                    prefixIcon:const Icon(Icons.alternate_email),
                                    border:const OutlineInputBorder(),
                                    labelText: 'Username',
                                    errorText: _validate ? 'Value Can\'t Be Empty' : null,
                                  ),
                                ),
                              ),
                              Padding(
                                padding: EdgeInsets.fromLTRB(0, 15, 0, 10),
                                child: IntlPhoneField(
                                  controller: mobileNumber,
                                  decoration: InputDecoration(
                                    labelText: 'Phone Number',
                                    errorText: _validate ? 'Value Can\'t Be Empty' : null,
                                    border: const OutlineInputBorder(
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
                                    setState(() {
                                      username.text.isEmpty ? _validate = true : _validate = false;
                                      mobileNumber.text.isEmpty ? _validate = true : _validate = false;

                                      if(mobileNumber.text.isPhoneNumber && username.text.isNotEmpty){
                                        sentOTP();
                                      }
                                    });

                                  },
                                  child: const Text(
                                    'Sent OTP',
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

class LoginWithMobileNumber extends StatefulWidget {
  final String pUsername;
  final String pMobile;
  const LoginWithMobileNumber({Key? key, required this.pUsername, required this.pMobile}) : super(key: key);

  @override
  State<LoginWithMobileNumber> createState() => _LoginWithMobileNumberState();
}

class _LoginWithMobileNumberState extends State<LoginWithMobileNumber> {

  final pinController = TextEditingController();

  final focusNode = FocusNode();
  final formKey = GlobalKey<FormState>();


  String data = "";
  late Map mapres;
  late List listres = [];

  Future loginWithOTP() async {
    var url = Uri.parse("http://10.0.2.2/finalproject/admin/mobile-app-scripts/login-with-otp.php");
    var response = await http.post(url, body: {
      "username": widget.pUsername,
      "mobilenumber": widget.pMobile,
      "otp": pinController.text,
    });
    listres = jsonDecode(response.body);
    if (response.statusCode == 200) {
      if (listres[0]['status'] == true) {
        print("Pin Controller Name: "+pinController.text);
        final SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
        sharedPreferences.setString('patientID', listres[0]['patient'].toString());
        Fluttertoast.showToast(
            msg: "Login Success..!! Welcome to GB Health Care Patient System",
            toastLength: Toast.LENGTH_SHORT,
            gravity: ToastGravity.CENTER,
            timeInSecForIosWeb: 1,
            textColor: Colors.white,
            backgroundColor: Colors.green,
            fontSize: 19.0
        );
        Navigator.push(context, MaterialPageRoute(builder: (context) => myHome()));
      }
    }else{
      return Fluttertoast.showToast(
          msg: "Internal Server Error ${response.statusCode} - ${listres[0]['message']} ",
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.CENTER,
          timeInSecForIosWeb: 1,
          textColor: Colors.red,
          fontSize: 16.0
      );
    }
  }


  @override
  void dispose() {
    pinController.dispose();
    focusNode.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    const focusedBorderColor = Color.fromRGBO(23, 171, 144, 1);
    const fillColor = Color.fromRGBO(243, 246, 249, 0);
    const borderColor = Color.fromRGBO(23, 171, 144, 0.4);

    final defaultPinTheme = PinTheme(
      width: 56,
      height: 56,
      textStyle: const TextStyle(
        fontSize: 22,
        color: Color.fromRGBO(30, 60, 87, 1),
      ),
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(19),
        border: Border.all(color: borderColor),
      ),
    );

    /// Optionally you can use form to validate the Pinput
    /*return Scaffold(
      body: Form(
        key: formKey,
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Directionality(
              // Specify direction if desired
              textDirection: TextDirection.ltr,
              child: Pinput(
                controller: pinController,
                focusNode: focusNode,
                androidSmsAutofillMethod:
                AndroidSmsAutofillMethod.smsUserConsentApi,
                listenForMultipleSmsOnAndroid: true,
                defaultPinTheme: defaultPinTheme,
                validator: (value) {
                  return value == '2222' ? null : 'Pin is incorrect';
                },
                hapticFeedbackType: HapticFeedbackType.lightImpact,
                onCompleted: (pin) {
                  debugPrint('onCompleted: $pin');
                },
                onChanged: (value) {
                  debugPrint('onChanged: $value');
                },
                cursor: Column(
                  mainAxisAlignment: MainAxisAlignment.end,
                  children: [
                    Container(
                      margin: const EdgeInsets.only(bottom: 9),
                      width: 22,
                      height: 1,
                      color: focusedBorderColor,
                    ),
                  ],
                ),
                focusedPinTheme: defaultPinTheme.copyWith(
                  decoration: defaultPinTheme.decoration!.copyWith(
                    borderRadius: BorderRadius.circular(8),
                    border: Border.all(color: focusedBorderColor),
                  ),
                ),
                submittedPinTheme: defaultPinTheme.copyWith(
                  decoration: defaultPinTheme.decoration!.copyWith(
                    color: fillColor,
                    borderRadius: BorderRadius.circular(19),
                    border: Border.all(color: focusedBorderColor),
                  ),
                ),
                errorPinTheme: defaultPinTheme.copyBorderWith(
                  border: Border.all(color: Colors.redAccent),
                ),
              ),
            ),
            TextButton(
              onPressed: () => formKey.currentState!.validate(),
              child: const Text('Validate'),
            ),
          ],
        ),
      ),
    );*/

    return Scaffold(
      body: MaterialApp(
        debugShowCheckedModeBanner: false,
        theme: ThemeData(fontFamily: 'Lato'),
        home: Scaffold(
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
                                const Text("Verification",
                                    style:
                                        TextStyle(fontSize: 30.0, color: appThemeColor, fontWeight: FontWeight.bold)),
                                const SizedBox(height: 10),
                                const Text(
                                  "Enter you OTP here",
                                  textAlign: TextAlign.center,
                                ),
                                Padding(
                                  padding: EdgeInsets.fromLTRB(0, 20, 0, 10),
                                  child: Form(
                                    key: formKey,
                                    child: Column(
                                      mainAxisAlignment: MainAxisAlignment.center,
                                      children: [
                                        Pinput(
                                          controller: pinController,
                                          focusNode: focusNode,
                                          androidSmsAutofillMethod: AndroidSmsAutofillMethod.smsUserConsentApi,
                                          listenForMultipleSmsOnAndroid: true,
                                          defaultPinTheme: defaultPinTheme,
                                          hapticFeedbackType: HapticFeedbackType.lightImpact,
                                          onCompleted: (pin) {
                                            debugPrint('onCompleted: $pin');
                                          },
                                          cursor: Column(
                                            mainAxisAlignment: MainAxisAlignment.end,
                                            children: [
                                              Container(
                                                margin: const EdgeInsets.only(bottom: 9),
                                                width: 22,
                                                height: 1,
                                                color: focusedBorderColor,
                                              ),
                                            ],
                                          ),
                                          focusedPinTheme: defaultPinTheme.copyWith(
                                            decoration: defaultPinTheme.decoration!.copyWith(
                                              borderRadius: BorderRadius.circular(8),
                                              border: Border.all(color: focusedBorderColor),
                                            ),
                                          ),
                                          submittedPinTheme: defaultPinTheme.copyWith(
                                            decoration: defaultPinTheme.decoration!.copyWith(
                                              color: fillColor,
                                              borderRadius: BorderRadius.circular(19),
                                              border: Border.all(color: focusedBorderColor),
                                            ),
                                          ),
                                          errorPinTheme: defaultPinTheme.copyBorderWith(
                                            border: Border.all(color: Colors.redAccent),
                                          ),
                                        ),
                                        const SizedBox(
                                          height: 25,
                                        )
                                      ],
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
                                      loginWithOTP();
                                    },
                                    child: const Text(
                                      'Continue',
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
      ),
    );
  }
}
