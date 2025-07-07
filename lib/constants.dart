import 'package:flutter/material.dart';

const Color appThemeColor = Color.fromRGBO(11, 1, 187, 0.8);
const Color appBgDefault = Color.fromRGBO(236, 241, 250, 1.0);
const Color appSecThemeColor = Color.fromRGBO(61, 109, 255, 1.0);

const Color appThemeColor2 = Color.fromRGBO(24, 20, 97, 1.0);

// For Gradients
const Color colorGra1 = Color.fromRGBO(130, 130, 193, 1.0);

showAlertDialog(BuildContext context) {

  // set up the buttons
  Widget cancelButton = TextButton(
    child: Text("Cancel"),
    onPressed:  () {},
  );
  Widget continueButton = TextButton(
    child: Text("Continue"),
    onPressed:  () {},
  );

  // set up the AlertDialog
  AlertDialog alert = AlertDialog(
    title: Text("AlertDialog"),
    content: Text("Would you like to continue learning how to use Flutter alerts?"),
    actions: [
      cancelButton,
      continueButton,
    ],
  );

  // show the dialog
  showDialog(
    context: context,
    builder: (BuildContext context) {
      return alert;
    },
  );
}
