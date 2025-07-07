import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:cupertino_icons/cupertino_icons.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:smart_hrms_app/Screens/PrescriptionHistory.dart';
import 'package:smart_hrms_app/Screens/ViewAllAppointment.dart';
import 'package:smart_hrms_app/Screens/ViewAllMedicalRecords.dart';
import 'package:smart_hrms_app/Screens/testingGet.dart';
import 'package:smart_hrms_app/services/notification.dart';
import '../constants.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:http/http.dart' as http;
import 'package:intl/intl.dart';
import '../modals/all-fetch-api.dart';
import '../modals/get-loggedUserInfo.dart';
import 'userNameLogin.dart';
import 'mediRecordDetail.dart';
import 'PrescriptionDetails.dart';
import 'package:provider/provider.dart';

double deviceHeight(BuildContext context) => MediaQuery.of(context).size.height;
double deviceWidth(BuildContext context) => MediaQuery.of(context).size.width;

var finalSessionID;

class myHome extends StatefulWidget {
  const myHome({Key? key}) : super(key: key);

  @override
  State<myHome> createState() => _myHomeState();
}

class _myHomeState extends State<myHome> {
  final GlobalKey<ScaffoldState> _scaffoldKey = new GlobalKey<ScaffoldState>();

  String patientID = " ";
  String data = "";
  late Map mapres;
  late List listres = [];

  late List patientCredentialInfo = [];

  Future getSessionData() async {
    final SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
    var obtainedSession = sharedPreferences.getString('patientID');
    setState(() {
      finalSessionID = obtainedSession;
      patientID = finalSessionID;
    });
  }

  Future apicall() async {
    http.Response response;
    var url = "http://10.0.2.2/finalproject/admin/mobile-app-scripts/get-booking.php?id=" + patientID;
    print(url);
    response = await http.get(Uri.parse(url));
    if (response.statusCode == 200) {
      setState(() {
        listres = jsonDecode(response.body);
        /*listres = mapres['data'];*/
      });
    }
  }

  @override
  void initState() {
    getSessionData().whenComplete(() async {
      print("Print in the initState: "+finalSessionID);
      () => Get.to(finalSessionID == null ? applicationNew() : myHome());
      apicall();
    });

    super.initState();
  }


  @override
  Widget build(BuildContext context) {
    Size size = MediaQuery.of(context).size;
    // It provide us total height and width
    return Scaffold(
      key: _scaffoldKey,
      drawer: FutureBuilder(
        future: fetchLoggedUserDetail(patientID),
        builder: (context, snapshot) {
          if (snapshot.hasData) {
            LoggedUserInfo loggedUserDetails = snapshot.data![0];
            print(snapshot.data.toString());
            return Drawer(
              child: ListView(
                // Important: Remove any padding from the ListView.
                padding: EdgeInsets.zero,
                children: <Widget>[
                  UserAccountsDrawerHeader(
                    accountName: Text("${loggedUserDetails.pName}"),
                    accountEmail: Text("${loggedUserDetails.pContact}"),
                    currentAccountPicture: CircleAvatar(
                      backgroundImage: NetworkImage("http://10.0.2.2/finalproject/admin/uploads/patient/${loggedUserDetails.pImg}"),
                    ),
                  ),
                  ListTile(
                    leading: Icon(Icons.home),
                    title: Text("Home"),
                    onTap: () => Navigator.push(
                      context,
                      MaterialPageRoute(builder: (context) => const myHome()),
                    ),
                  ),
                  ListTile(
                    leading: Icon(Icons.calendar_month),
                    title: Text("My Appoinments"),
                    onTap: () => Navigator.push(
                      context,
                      MaterialPageRoute(builder: (context) => const ViewAllAppointment()),
                    ),
                  ),
                  ListTile(
                    leading: Icon(Icons.receipt),
                    title: Text("Medical Record"),
                    onTap: () => Navigator.push(
                      context,
                      MaterialPageRoute(builder: (context) => const myHome()),
                    ),
                  ),
                  ListTile(
                    leading: Icon(Icons.contacts),
                    title: Text("Account Settings"),
                    onTap: () {
                      Navigator.pop(context);
                    },
                  ),
                  ListTile(
                      leading: const Icon(Icons.logout),
                      title: const Text("Sign out"),
                      onTap: () async{
                        final SharedPreferences prefs  = await SharedPreferences.getInstance();
                        prefs.remove('patientID');
                        finalSessionID = "";
                        Navigator.pushReplacement(context, MaterialPageRoute(builder: (context) => applicationNew()));
                      }
                  ),
                ],
              ),
            );
          } else if (snapshot.hasError) {
            return Container(child: Text('No Medical Records Found'));
          }
          return CircularProgressIndicator();
        },
      ),
      body: FutureBuilder(
        future: fetchLoggedUserDetail(patientID),
        builder: (context, snapshot) {
          if (snapshot.hasData) {
            LoggedUserInfo loggedUserDetails = snapshot.data![0];
            return RefreshIndicator(
              onRefresh: () async {
                apicall();
                ScaffoldMessenger.of(context).showSnackBar(
                  const SnackBar(
                    content: Text('Page Refreshed'),
                  ),
                );
              },
              child: SingleChildScrollView(
                physics: const AlwaysScrollableScrollPhysics(),
                child: Column(
                  children: <Widget>[
                    SizedBox(
                      height: 400,
                      child: Stack(
                        children: <Widget>[
                          Container(
                            width: double.infinity,
                            height: size.height * 0.21,
                            // height: 500,
                            decoration: const BoxDecoration(
                              gradient: LinearGradient(
                                begin: Alignment.topRight,
                                end: Alignment.bottomLeft,
                                colors: [
                                  appSecThemeColor,
                                  colorGra1,
                                ],
                              ),
                              borderRadius: BorderRadius.only(
                                topLeft: Radius.circular(24),
                                topRight: Radius.circular(24),
                              ),
                            ),
                          ),
                          Container(
                              margin: EdgeInsets.only(top: size.height * 0.11),
                              width: double.infinity,
                              height: double.infinity,
                              decoration: const BoxDecoration(
                                color: Color.fromRGBO(246, 246, 246, 1.0),
                                borderRadius: BorderRadius.only(
                                  topLeft: Radius.circular(24),
                                  topRight: Radius.circular(24),
                                ),
                              )),
                          SafeArea(
                              child: Column(
                                children: [
                                  Container(
                                    height: size.height * 0.08,
                                    child: Row(
                                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                      children: [
                                        Padding(
                                          padding: const EdgeInsets.fromLTRB(20, 0, 0, 0),
                                          child: IconButton(
                                            icon: const Icon(
                                              Icons.menu,
                                              size: 35,
                                              color: Colors.white,
                                            ),
                                            onPressed: () => _scaffoldKey.currentState?.openDrawer(),
                                          ),
                                        ),
                                        /*TextButton(
                                            onPressed: () async {
                                              final SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
                                              sharedPreferences.remove('patientID');
                                              Navigator.push(context, MaterialPageRoute(builder: (context) => applicationNew()));
                                            },
                                            child: Text("Logout")),*/
                                        Padding(
                                          padding: const EdgeInsets.fromLTRB(0, 0, 20, 0),
                                          child: GestureDetector(
                                            child: CircleAvatar(
                                              backgroundImage: NetworkImage(
                                                  "http://10.0.2.2/finalproject/admin/uploads/patient/${loggedUserDetails.pImg}"),
                                            ),
                                          ),
                                        ),
                                      ],
                                    ),
                                  ),
                                  Container(
                                    alignment: Alignment.centerLeft,
                                    margin: const EdgeInsets.fromLTRB(25, 25, 25, 0),
                                    child: Column(
                                      mainAxisAlignment: MainAxisAlignment.start,
                                      crossAxisAlignment: CrossAxisAlignment.start,
                                      children: [
                                        Text(
                                          "Hi, ${loggedUserDetails.pName}", // User Name will be Displayed Here
                                          style: GoogleFonts.roboto(
                                              fontStyle: FontStyle.normal, fontWeight: FontWeight.w400, fontSize: 30),
                                        ),
                                        Text(
                                          "Welcome Back",
                                          style: GoogleFonts.roboto(
                                              fontStyle: FontStyle.normal, fontWeight: FontWeight.w700, fontSize: 30),
                                        ),
                                        const SizedBox(
                                          height: 20,
                                        ),
                                        ListView(shrinkWrap: true, children: <Widget>[
                                          Container(
                                            height: 165.0,
                                            child: ListView(
                                              physics: BouncingScrollPhysics(),
                                              scrollDirection: Axis.horizontal,
                                              children: [
                                                GestureDetector(
                                                  child: Container(
                                                    padding: EdgeInsets.all(10.0),
                                                    decoration: const BoxDecoration(
                                                        color: Colors.white, borderRadius: BorderRadius.all(Radius.circular(10))),
                                                    child: Column(
                                                      children: [
                                                        const Padding(
                                                          padding: EdgeInsets.fromLTRB(0, 0, 0, 10),
                                                          child: Text(
                                                            "Medical Record",
                                                            style: TextStyle(color: appThemeColor, fontWeight: FontWeight.w500),
                                                          ),
                                                        ),
                                                        Padding(
                                                          padding: const EdgeInsets.all(8.0),
                                                          child: Image.asset(
                                                            "images/slider/slide-1.png",
                                                            width: 80,
                                                          ),
                                                        ),
                                                      ],
                                                    ),
                                                  ),
                                                  onTap: () {
                                                    Navigator.push(
                                                      context,
                                                      MaterialPageRoute(builder: (context) => const ViewAllMedicalRecords()),
                                                    );
                                                  },
                                                ),
                                                const SizedBox(
                                                  width: 20,
                                                ),
                                                GestureDetector(
                                                  child: Container(
                                                    padding: EdgeInsets.all(10.0),
                                                    decoration: const BoxDecoration(
                                                        color: Colors.white, borderRadius: BorderRadius.all(Radius.circular(10))),
                                                    child: Column(
                                                      children: [
                                                        const Padding(
                                                          padding: EdgeInsets.fromLTRB(0, 0, 0, 10),
                                                          child: Text(
                                                            "Appointment",
                                                            style: TextStyle(
                                                              color: appThemeColor,
                                                              fontWeight: FontWeight.w500,
                                                            ),
                                                          ),
                                                        ),
                                                        Padding(
                                                          padding: const EdgeInsets.all(8.0),
                                                          child: Image.asset(
                                                            "images/slider/slide-2.png",
                                                            width: 100,
                                                          ),
                                                        ),
                                                      ],
                                                    ),
                                                  ),
                                                  onTap: () {
                                                    Navigator.push(
                                                        context,
                                                        MaterialPageRoute( builder: (context) => ViewAllAppointment() ));
                                                    // showAlertDialog(context);
                                                  },
                                                ),
                                                const SizedBox(
                                                  width: 20,
                                                ),
                                                GestureDetector(
                                                  child: Container(
                                                    padding: EdgeInsets.all(10.0),
                                                    decoration: const BoxDecoration(
                                                        color: Colors.white, borderRadius: BorderRadius.all(Radius.circular(10))),
                                                    child: Column(
                                                      children: [
                                                        const Padding(
                                                          padding: EdgeInsets.fromLTRB(0, 0, 0, 10),
                                                          child: Text(
                                                            "Prescription",
                                                            style: TextStyle(
                                                              color: appThemeColor,
                                                              fontWeight: FontWeight.w500,
                                                            ),
                                                          ),
                                                        ),
                                                        Padding(
                                                          padding: const EdgeInsets.all(8.0),
                                                          child: Image.asset(
                                                            "images/slider/slide-3.png",
                                                            width: 100,
                                                          ),
                                                        ),
                                                      ],
                                                    ),
                                                  ),
                                                  onTap: () {
                                                    Navigator.push(
                                                      context,
                                                      MaterialPageRoute(builder: (context) => const PrescriptionHistory()),
                                                    );
                                                  },
                                                ),
                                              ],
                                            ),
                                          ),
                                          const SizedBox(
                                            height: 15,
                                          ),
                                        ])
                                      ],
                                    ),
                                  ),
                                ],
                              ))
                        ],
                      ),
                    ),
                    SingleChildScrollView(
                      child: Container(
                        padding: EdgeInsets.fromLTRB(25, 0, 25, 25),
                        decoration: const BoxDecoration(
                          color: Color.fromRGBO(246, 246, 246, 1.0),
                        ),
                        child: Column(
                          children: [
                            Row(
                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                              children: [
                                Text(
                                  "Recent Medical Records",
                                  style: GoogleFonts.roboto(
                                      fontStyle: FontStyle.normal, fontWeight: FontWeight.w400, fontSize: 20),
                                ),
                                TextButton(
                                    style: TextButton.styleFrom(
                                      backgroundColor: Colors.white,
                                    ),
                                    onPressed: () {
                                      Navigator.push(context, MaterialPageRoute(builder: (context) => ViewAllMedicalRecords()));
                                    },
                                    child: const Text('Show All')),
                              ],
                            ),
                            SingleChildScrollView(
                              child: Column(
                                children: [
                                  ListView.builder(
                                    physics: NeverScrollableScrollPhysics(),
                                    scrollDirection: Axis.vertical,
                                    shrinkWrap: true,
                                    itemBuilder: (context, index) {
                                      return Column(
                                        mainAxisAlignment: MainAxisAlignment.start,
                                        mainAxisSize: MainAxisSize.min,
                                        children: [
                                          Row(
                                            mainAxisSize: MainAxisSize.min,
                                            children: [
                                              Expanded(
                                                child: Container(
                                                  decoration: BoxDecoration(
                                                    borderRadius: BorderRadius.circular(10),
                                                    gradient: const LinearGradient(
                                                        begin: Alignment.topRight,
                                                        end: Alignment.bottomLeft,
                                                        colors: [
                                                          appSecThemeColor,
                                                          appThemeColor,
                                                        ]),
                                                  ),
                                                  padding: const EdgeInsets.all(25),
                                                  child: Column(
                                                    crossAxisAlignment: CrossAxisAlignment.start,
                                                    children: [
                                                      Text(
                                                        DateFormat('dd-MMM-y').format(
                                                            DateTime.tryParse(listres[index]['book_allocateDateTime'])
                                                            as DateTime),
                                                        style: GoogleFonts.roboto(
                                                            color: Colors.white,
                                                            fontStyle: FontStyle.normal,
                                                            fontWeight: FontWeight.w800,
                                                            fontSize: 22),
                                                      ),
                                                      const SizedBox(
                                                        height: 5,
                                                      ),
                                                      Text(
                                                        "Doctor In-Charge: ${listres[index]['doc_name']}",
                                                        style: GoogleFonts.roboto(
                                                            color: Colors.white54,
                                                            fontStyle: FontStyle.normal,
                                                            fontWeight: FontWeight.w500,
                                                            fontSize: 12),
                                                      ),
                                                      const SizedBox(
                                                        height: 5,
                                                      ),
                                                      Text(
                                                        "Status: ${listres[index]['bookStatus_name']}",
                                                        style: GoogleFonts.roboto(
                                                            color: Colors.white54,
                                                            fontStyle: FontStyle.normal,
                                                            fontWeight: FontWeight.w500,
                                                            fontSize: 12),
                                                      ),
                                                      const SizedBox(
                                                        height: 5,
                                                      ),
                                                      Text(
                                                        listres[index]['book_desc'],
                                                        style: GoogleFonts.roboto(
                                                            color: Colors.white,
                                                            fontStyle: FontStyle.normal,
                                                            fontWeight: FontWeight.w400,
                                                            fontSize: 12),
                                                      ),
                                                      const SizedBox(
                                                        height: 5,
                                                      ),
                                                      Row(
                                                        children: [
                                                          TextButton(
                                                              style: ButtonStyle(
                                                                  foregroundColor:
                                                                  MaterialStateProperty.all<Color>(appSecThemeColor),
                                                                  backgroundColor:
                                                                  MaterialStateProperty.all<Color>(Colors.white),
                                                                  shape: MaterialStateProperty.all<RoundedRectangleBorder>(
                                                                      RoundedRectangleBorder(
                                                                        borderRadius: BorderRadius.circular(12.0),
                                                                      ))),
                                                              onPressed: () {
                                                                listres[index]['bookStatus_name'] == "Done"
                                                                    ? print('PressedButton')
                                                                    : print('DisableButton');
                                                              },
                                                              child: const Text('View Details')),
                                                          Padding(
                                                            padding: const EdgeInsets.only(left: 15),
                                                            child: Visibility(
                                                              visible:
                                                              listres[index]['mediRec_id'] != null ? true : false,
                                                              child: TextButton(
                                                                  style: ButtonStyle(
                                                                      foregroundColor:
                                                                      MaterialStateProperty.all<Color>(Colors.white),
                                                                      shape: MaterialStateProperty
                                                                          .all<RoundedRectangleBorder>(RoundedRectangleBorder(
                                                                          borderRadius: BorderRadius.circular(12.0),
                                                                          side: const BorderSide(color: Colors.white)))),
                                                                  onPressed: () {
                                                                   Navigator.push(
                                                                        context,
                                                                        MaterialPageRoute( builder: (context) => MedicalRecordDetail(medicalRecordID: listres[index]['mediRec_id'].toString())));
                                                                  },
                                                                  child: const Text('Show Medicines')),
                                                            ),
                                                          ),
                                                        ],
                                                      )
                                                    ],
                                                  ),
                                                ),
                                              )
                                            ],
                                          ),
                                          Row(
                                            mainAxisSize: MainAxisSize.min,
                                            children: const [
                                              SizedBox(
                                                height: 15,
                                              ),
                                            ],
                                          ),
                                        ],
                                      );
                                    },
                                    itemCount: listres.length,
                                  ),
                                ],
                              ),
                            ),
                            const SizedBox(
                              height: 15,
                            ),
                          ],
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            );
          } else if (snapshot.hasError) {
            return Container(child: Text('No Medical Records Found'));
            // print("No Data in the Snapshot");
          }
          return CircularProgressIndicator();
        },
      ),
    );
  }
}
