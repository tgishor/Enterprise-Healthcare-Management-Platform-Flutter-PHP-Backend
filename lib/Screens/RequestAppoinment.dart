import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:multi_select_flutter/multi_select_flutter.dart';

import '../constants.dart';

class RequestAppointment extends StatefulWidget {
  const RequestAppointment({Key? key}) : super(key: key);

  @override
  State<RequestAppointment> createState() => _RequestAppointmentState();
}

class _RequestAppointmentState extends State<RequestAppointment> {

  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        backgroundColor: Color.fromRGBO(236, 241, 250, 1),
        appBar: AppBar(
          backgroundColor: Colors.transparent,
          elevation: 0.0,
          leading: IconButton(
            icon: const Icon(Icons.arrow_back, color: appThemeColor2),
            onPressed: () => Navigator.of(context).pop(),
          ),
          actions: const [
            Padding(
              padding: EdgeInsets.fromLTRB(0, 0, 20, 0),
              child: CircleAvatar(
                backgroundImage: NetworkImage(
                    "https://imgnew.outlookindia.com/uploadimage/library/16_9/16_9_5/IMAGE_1666607184.jpg",
                    scale: 1),
              ),
            ),
          ],
        ),
        body: Container(
          margin: EdgeInsets.all(20),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.start,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                "Request Appointment", // User Name will be Displayed Here
                style: GoogleFonts.roboto(
                    fontStyle: FontStyle.normal, fontWeight: FontWeight.w700, fontSize: 25, color: Colors.black),
              ),
              SizedBox(height: 30,),
              Text(
                "Disease Faced", // User Name will be Displayed Here
                style: GoogleFonts.roboto(
                    fontStyle: FontStyle.normal, fontWeight: FontWeight.w600, fontSize: 18, color: Colors.black),
              ),
              SizedBox(height: 10,),
              TextField(
                decoration: InputDecoration(
                    focusColor: Colors.cyan,
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12.0),
                      borderSide: const BorderSide(
                        width: 0,
                        style: BorderStyle.none,
                      ),
                    ),
                    filled: true,
                    hintStyle: TextStyle(color: Colors.grey[400]),
                    hintText: "Enter your Problem here",
                    fillColor: Colors.white),
              ),
              SizedBox(height: 22,),
              Text(
                "Contact No.", // User Name will be Displayed Here
                style: GoogleFonts.roboto(
                    fontStyle: FontStyle.normal, fontWeight: FontWeight.w600, fontSize: 18, color: Colors.black),
              ),
              SizedBox(height: 10,),
              TextField(
                decoration: InputDecoration(
                    focusColor: Colors.cyan,
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12.0),
                      borderSide: const BorderSide(
                        width: 0,
                        style: BorderStyle.none,
                      ),
                    ),
                    filled: true,
                    hintStyle: TextStyle(color: Colors.grey[400]),
                    hintText: "Enter Contact Number Here",
                    fillColor: Colors.white),
              ),
              SizedBox(height: 22,),
              Text(
                "Needed Treatment Date", // User Name will be Displayed Here
                style: GoogleFonts.roboto(
                    fontStyle: FontStyle.normal, fontWeight: FontWeight.w600, fontSize: 18, color: Colors.black),
              ),
              SizedBox(height: 10,),
              TextField(
                decoration: InputDecoration(
                    focusColor: Colors.cyan,
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12.0),
                      borderSide: const BorderSide(
                        width: 0,
                        style: BorderStyle.none,
                      ),
                    ),
                    filled: true,
                    hintStyle: TextStyle(color: Colors.grey[400]),
                    hintText: "Enter Treatment Date Here",
                    fillColor: Colors.white),
              ),
              SizedBox(height: 22,),
              Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  TextButton(
                      onPressed: () => print('hello'),
                      style: ButtonStyle(
                          foregroundColor: MaterialStateProperty.all<Color>(Colors.white),
                          backgroundColor:
                          MaterialStateProperty.all<Color>(Color.fromRGBO(0, 51, 167, 0.8)),
                          shape: MaterialStateProperty.all<RoundedRectangleBorder>(
                              RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(18.0)))),
                      child: const Padding(
                        padding: EdgeInsets.fromLTRB(15, 5, 15, 5),
                        child: Text(
                          "Request Appointment",
                          style: TextStyle(fontSize: 14, fontWeight: FontWeight.w800),
                        ),
                      )),
                ],
              )

            ],
          ),
        ));
  }
}
