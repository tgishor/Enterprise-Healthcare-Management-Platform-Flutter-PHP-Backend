import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:smart_hrms_app/Screens/userNameLogin.dart';

import '../constants.dart';
import '../modals/all-fetch-api.dart';
import '../modals/get-loggedUserInfo.dart';
import '../modals/get-medicalRecordDetailed.dart';
import '../modals/mediDetails.dart';
import 'ViewAllMedicalRecords.dart';

import 'package:carousel_slider/carousel_slider.dart';

var finalSessionID;

class MedicalDetailScreen extends StatefulWidget {
  final String medicine_id;
  const MedicalDetailScreen({Key? key,required this.medicine_id}) : super(key: key);

  @override
  State<MedicalDetailScreen> createState() => _MedicalDetailScreenState();
}

class _MedicalDetailScreenState extends State<MedicalDetailScreen> {
  String patientID = " ";

  Future getSessionData() async {
    final SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
    var obtainedSession = sharedPreferences.getString('patientID');
    print("Obtained Session Print" + obtainedSession.toString());
    setState(() {
      finalSessionID = obtainedSession;
      patientID = finalSessionID;
    });
  }

  @override
  void initState() {
    getSessionData().whenComplete(() async {
          () => Get.to(finalSessionID == null ? applicationNew() : ViewAllMedicalRecords());
    });
    super.initState();
  }




  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: PreferredSize(
        preferredSize: const Size.fromHeight(60),
        child: FutureBuilder(
          future: fetchLoggedUserDetail(patientID),
          builder: (context, snapshot) {
            if (snapshot.hasData) {
              LoggedUserInfo loggedUserDetails = snapshot.data![0];
              print(snapshot.data.toString());
              return AppBar(
                backgroundColor: Colors.transparent,
                elevation: 0.0,
                leading: IconButton(
                  icon: const Icon(Icons.arrow_back, color: appThemeColor2),
                  onPressed: () => Navigator.of(context).pop(),
                ),
                actions: [
                  Padding(
                    padding: EdgeInsets.fromLTRB(0, 0, 20, 0),
                    child: CircleAvatar(
                      backgroundImage: NetworkImage(
                          "http://10.0.2.2/finalproject/admin/uploads/patient/${loggedUserDetails.pImg}"),
                    ),
                  ),
                ],
                title: const Text("Medicine Detail", style: TextStyle(color: Colors.black)),
              );
            } else if (snapshot.hasError) {
              return Container(child: Text('No User Found'));
            }
            return CircularProgressIndicator();
          },
        ),
      ),
      body: Container(
        margin: const EdgeInsets.all(20),
        child: FutureBuilder(
          future: fetchMedicineDetail(widget.medicine_id),
          builder: (context, AsyncSnapshot<List<MediDetails>> snapshot){
            if (snapshot.hasData) {
              MediDetails mediDetail = snapshot.data![0];
              return Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  CarouselSlider(
                    items: [
                      //1st Image of Slider
                      Container(
                        width: double.maxFinite,
                        margin: EdgeInsets.all(6.0),
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(8.0),
                          image: DecorationImage(
                            image: NetworkImage('http://10.0.2.2/finalproject/admin/uploads/medicine/frontimage/${mediDetail.mediFrontImg}'),
                            fit: BoxFit.cover,
                          ),
                        ),
                      ),

                      //2nd Image of Slider
                      Container(
                        width: double.maxFinite,
                        margin: EdgeInsets.all(6.0),
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(8.0),
                          image: DecorationImage(
                            image: NetworkImage("http://10.0.2.2/finalproject/admin/uploads/medicine/backimage/${mediDetail.mediBackImg}"),
                            fit: BoxFit.cover,
                          ),
                        ),
                      ),
                    ],

                    //Slider Container properties
                    options: CarouselOptions(
                      height: 300.0,
                      enlargeCenterPage: true,
                      autoPlay: true,
                      aspectRatio: 16 / 9,
                      autoPlayCurve: Curves.fastOutSlowIn,
                      enableInfiniteScroll: true,
                      autoPlayAnimationDuration: Duration(milliseconds: 1000),
                      viewportFraction: 0.8,
                    ),
                  ),
                  const SizedBox(
                    height: 20,
                  ),
                  Text(
                    "${mediDetail.mediName}", // User Name will be Displayed Here
                    style: GoogleFonts.roboto(
                        fontStyle: FontStyle.normal,
                        fontWeight: FontWeight.w800,
                        fontSize: 21,
                        color: Colors.black),
                  ),
                  const SizedBox(
                    height: 10,
                  ),
                  Row(
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      Text(
                        "Drug Type: ", // User Name will be Displayed Here
                        style: GoogleFonts.roboto(
                            fontStyle: FontStyle.normal,
                            fontWeight: FontWeight.w800,
                            fontSize: 15,
                            color: Colors.black),
                      ),
                      Text(
                        "${mediDetail.dTypeName}", // User Name will be Displayed Here
                        style: GoogleFonts.roboto(
                            fontStyle: FontStyle.normal,
                            fontWeight: FontWeight.w600,
                            fontSize: 15,
                            color: Colors.black),
                      ),
                    ],
                  ),
                  const SizedBox(
                    height: 10,
                  ),
                  Row(
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      Text(
                        "Medicine Code: ", // User Name will be Displayed Here
                        style: GoogleFonts.roboto(
                            fontStyle: FontStyle.normal,
                            fontWeight: FontWeight.w800,
                            fontSize: 15,
                            color: Colors.black),
                      ),
                      Text(
                        "${mediDetail.mediPillCode}", // User Name will be Displayed Here
                        style: GoogleFonts.roboto(
                            fontStyle: FontStyle.normal,
                            fontWeight: FontWeight.w600,
                            fontSize: 15,
                            color: Colors.black),
                      ),
                    ],
                  ),
                  const SizedBox(
                    height: 10,
                  ),
                  Text(
                    "Usage Description: ", // User Name will be Displayed Here
                    style: GoogleFonts.roboto(
                        fontStyle: FontStyle.normal,
                        fontWeight: FontWeight.w800,
                        fontSize: 15,
                        color: Colors.black),
                  ),
                  SizedBox(height: 5,),
                  SizedBox(
                    width: 500,
                    child: Text(
                      "${mediDetail.mediUsageDesc}", // User Name will be Displayed Here
                      style: GoogleFonts.roboto(
                          fontStyle: FontStyle.normal,
                          fontWeight: FontWeight.w600,
                          fontSize: 15,
                          color: Colors.black),
                    ),
                  ),
                ],
              );
            }else if (snapshot.hasError) {
              return Container(child: Text('No Medical Record Details Found'));
              // print("No Data in the Snapshot");
            }
            return Container(height: 550,child: Center(child: CircularProgressIndicator(),),);
          },
        )


      ),
    );

  }
}
