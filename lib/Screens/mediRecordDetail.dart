import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:intl/intl.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../constants.dart';
import '../modals/all-fetch-api.dart';
import '../modals/get-loggedUserInfo.dart';
import '../modals/get-medicalRecordDetailed.dart';
import 'PrescriptionDetails.dart';
import 'userNameLogin.dart';


var finalSessionID;

class MedicalRecordDetail extends StatefulWidget {
  final String medicalRecordID;
  const MedicalRecordDetail({Key? key, required this.medicalRecordID}) : super(key: key);

  @override
  State<MedicalRecordDetail> createState() => _MedicalRecordDetailState();
}

class _MedicalRecordDetailState extends State<MedicalRecordDetail> {

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
          () => Get.to(finalSessionID == null ? applicationNew() : MedicalRecordDetail(medicalRecordID: widget.medicalRecordID,));
    });
    super.initState();
  }


  @override
  Widget build(BuildContext context) {
    double c_width = MediaQuery.of(context).size.width * 0.74;
    double c_width_doctor = MediaQuery.of(context).size.width * 0.45;

    return Scaffold(
      appBar: PreferredSize(
        preferredSize: const Size.fromHeight(60),
        child: FutureBuilder(
          future: fetchLoggedUserDetail(this.patientID),
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
                title: const Text("Medical Records Details", style: TextStyle(color: Colors.black)),
              );
            } else if (snapshot.hasError) {
              return Container(child: Text('No User Found'));
            }
            return CircularProgressIndicator();
          },
        ),
      ),
      body: SingleChildScrollView(
        child: SafeArea(
          child: Container(
              margin: EdgeInsets.all(20),
              child: FutureBuilder(
                future: fetchMediRecordDetails(widget.medicalRecordID),
                builder: (context, AsyncSnapshot<List<MedicalRecordDetailed>> snapshot){
                  if (snapshot.hasData) {
                    MedicalRecordDetailed mediRecDetail = snapshot.data![0];
                    return Column(
                      children: [
                        // Booking Details
                        Container(
                          width: double.infinity,
                          padding: EdgeInsets.all(30),
                          decoration: BoxDecoration(
                              borderRadius: BorderRadius.circular(10),
                              gradient: const LinearGradient(
                                begin: Alignment.topRight,
                                end: Alignment.bottomLeft,
                                colors: [
                                  appSecThemeColor,
                                  Color.fromRGBO(0, 51, 167, 1),
                                ],
                              ),
                              image: DecorationImage(
                                fit: BoxFit.cover,
                                colorFilter: ColorFilter.mode(Colors.black.withOpacity(0.2), BlendMode.dstATop),
                                image: const AssetImage(
                                  'images/background/bg-1.jpg',
                                ),
                              )),
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.start,
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Center(
                                child: Text(
                                  "Booking Details ", // User Name will be Displayed Here
                                  style: GoogleFonts.roboto(
                                      fontStyle: FontStyle.normal,
                                      fontWeight: FontWeight.w800,
                                      fontSize: 25,
                                      color: Colors.white),
                                ),
                              ),
                              const SizedBox(
                                height: 20,
                              ),
                              Row(
                                children: [
                                  Text(
                                    "Booking On: ", // User Name will be Displayed Here
                                    style: GoogleFonts.roboto(
                                        fontStyle: FontStyle.normal,
                                        fontWeight: FontWeight.w700,
                                        fontSize: 16,
                                        color: Colors.white),
                                  ),
                                  Text(
                                    "${DateFormat('dd-MMM-y').format(mediRecDetail.bookDateTime)}", // User Name will be Displayed Here
                                    style: GoogleFonts.roboto(
                                        fontStyle: FontStyle.normal,
                                        fontWeight: FontWeight.w500,
                                        fontSize: 15,
                                        color: Colors.white),
                                  ),
                                ],
                              ),
                              const SizedBox(
                                height: 12,
                              ),
                              Row(
                                children: [
                                  Text(
                                    "Appointment Date: ", // User Name will be Displayed Here
                                    style: GoogleFonts.roboto(
                                        fontStyle: FontStyle.normal,
                                        fontWeight: FontWeight.w700,
                                        fontSize: 16,
                                        color: Colors.white),
                                  ),
                                  Text(
                                    "${DateFormat('dd-MMM-y').format(mediRecDetail.bookAllocateDateTime)}", // User Name will be Displayed Here
                                    style: GoogleFonts.roboto(
                                        fontStyle: FontStyle.normal,
                                        fontWeight: FontWeight.w500,
                                        fontSize: 15,
                                        color: Colors.white),
                                  ),
                                ],
                              ),
                              const SizedBox(
                                height: 12,
                              ),
                              Row(
                                children: [
                                  Text(
                                    "Booking Status: ", // User Name will be Displayed Here
                                    style: GoogleFonts.roboto(
                                        fontStyle: FontStyle.normal,
                                        fontWeight: FontWeight.w700,
                                        fontSize: 16,
                                        color: Colors.white),
                                  ),
                                  if (mediRecDetail.bookStatusName == "Pending") ...[
                                    Container(
                                      padding: EdgeInsets.fromLTRB(10, 5, 15, 5),
                                      decoration: BoxDecoration(
                                        borderRadius: BorderRadius.circular(30),
                                        color: Colors.amber,
                                      ),
                                      child: Row(
                                        children: [
                                          Padding(
                                            padding: const EdgeInsets.fromLTRB(5, 0, 5, 0),
                                            child: Icon(Icons.pending_actions_rounded,color: Colors.white,size: 20,),
                                          ),
                                          Text(
                                            "Pending", // User Name will be Displayed Here
                                            style: GoogleFonts.roboto(
                                                fontStyle: FontStyle.normal,
                                                fontWeight: FontWeight.w800,
                                                fontSize: 13,
                                                color: Colors.white),
                                          ),
                                        ],
                                      ),
                                    ), // Pending Tag
                                  ] else if (mediRecDetail.bookStatusName == "Cancelled") ...[
                                    Container(
                                      padding: EdgeInsets.fromLTRB(10, 5, 15, 5),
                                      decoration: BoxDecoration(
                                        borderRadius: BorderRadius.circular(30),
                                        color: Colors.red,
                                      ),
                                      child: Row(
                                        children: [
                                          const Padding(
                                            padding: EdgeInsets.fromLTRB(5, 0, 5, 0),
                                            child: Icon(Icons.cancel_rounded  ,color: Colors.white,size: 20,),
                                          ),
                                          Text(
                                            "Cancelled", // User Name will be Displayed Here
                                            style: GoogleFonts.roboto(
                                                fontStyle: FontStyle.normal,
                                                fontWeight: FontWeight.w800,
                                                fontSize: 13,
                                                color: Colors.white),
                                          ),
                                        ],
                                      ),
                                    ), // Cancelled Tag
                                  ] else ...[
                                    Container(
                                      padding: EdgeInsets.fromLTRB(10, 5, 15, 5),
                                      decoration: BoxDecoration(
                                        borderRadius: BorderRadius.circular(30),
                                        color: const Color.fromRGBO(33, 232, 152, 1.0),
                                      ),
                                      child: Row(
                                        children: [
                                          const Padding(
                                            padding: const EdgeInsets.fromLTRB(5, 0, 5, 0),
                                            child: Icon(Icons.done_all_rounded,color: Colors.white,size: 20,),
                                          ),
                                          Text(
                                            "Done", // User Name will be Displayed Here
                                            style: GoogleFonts.roboto(
                                                fontStyle: FontStyle.normal,
                                                fontWeight: FontWeight.w800,
                                                fontSize: 13,
                                                color: Colors.white),
                                          ),
                                        ],
                                      ),
                                    ),  // Done Tag
                                  ]
                                ],
                              ),
                              const SizedBox(
                                height: 10,
                              ),
                              Container(
                                width: c_width,
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text(
                                      "Booking Description: ", // User Name will be Displayed Here
                                      style: GoogleFonts.roboto(
                                          fontStyle: FontStyle.normal,
                                          fontWeight: FontWeight.w700,
                                          fontSize: 16,
                                          color: Colors.white),
                                    ),
                                    Text(
                                      "${mediRecDetail.bookDesc.capitalizeFirst}",
                                      softWrap: true, // User Name will be Displayed Here
                                      style: GoogleFonts.roboto(
                                          fontStyle: FontStyle.normal,
                                          fontWeight: FontWeight.w500,
                                          fontSize: 15,
                                          color: Colors.white),
                                    ),
                                  ],
                                ),
                              ),
                            ],
                          ),
                        ),
                        const SizedBox(
                          height: 30,
                        ),
                        Container(
                          width: double.infinity,
                          padding: EdgeInsets.all(30),
                          decoration: BoxDecoration(
                              borderRadius: BorderRadius.circular(10),
                              gradient: const LinearGradient(
                                begin: Alignment.topRight,
                                end: Alignment.bottomLeft,
                                colors: [
                                  appSecThemeColor,
                                  Color.fromRGBO(0, 51, 167, 1),
                                ],
                              ),
                              image: DecorationImage(
                                fit: BoxFit.cover,
                                colorFilter: ColorFilter.mode(Colors.black.withOpacity(0.2), BlendMode.dstATop),
                                image: const AssetImage(
                                  'images/background/bg-2.jpg',
                                ),
                              )),
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.start,
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Row(
                                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                children: [
                                  Container(
                                    width: c_width_doctor,
                                    child: Column(
                                      crossAxisAlignment: CrossAxisAlignment.start,
                                      children: [
                                        Text(
                                          "Doctor Details ", // User Name will be Displayed Here
                                          style: GoogleFonts.roboto(
                                              fontStyle: FontStyle.normal,
                                              fontWeight: FontWeight.w800,
                                              fontSize: 25,
                                              color: Colors.white),
                                        ),
                                        const SizedBox(
                                          height: 10,
                                        ),
                                        Text(
                                          "Doctor Name: ", // User Name will be Displayed Here
                                          style: GoogleFonts.roboto(
                                              fontStyle: FontStyle.normal,
                                              fontWeight: FontWeight.w700,
                                              fontSize: 16,
                                              color: Colors.white),
                                        ),
                                        Text(
                                          "${mediRecDetail.docName}",
                                          softWrap: true, // User Name will be Displayed Here
                                          style: GoogleFonts.roboto(
                                              fontStyle: FontStyle.normal,
                                              fontWeight: FontWeight.w500,
                                              fontSize: 15,
                                              color: Colors.white),
                                        ),
                                        const SizedBox(
                                          height: 12,
                                        ),
                                        Row(
                                          children: [
                                            Text(
                                              "Type: ", // User Name will be Displayed Here
                                              style: GoogleFonts.roboto(
                                                  fontStyle: FontStyle.normal,
                                                  fontWeight: FontWeight.w700,
                                                  fontSize: 16,
                                                  color: Colors.white),
                                            ),
                                            Text(
                                              "${mediRecDetail.specilist == "1"? "Specialist" : "General"}", // User Name will be Displayed Here
                                              style: GoogleFonts.roboto(
                                                  fontStyle: FontStyle.normal,
                                                  fontWeight: FontWeight.w500,
                                                  fontSize: 15,
                                                  color: Colors.white),
                                            ),
                                          ],
                                        ),
                                      ],
                                    ),
                                  ),
                                  const SizedBox(
                                    width: 15,
                                  ),
                                  Container(
                                    alignment: Alignment.centerLeft,
                                    width: MediaQuery.of(context).size.width * 0.25,
                                    height: 110,
                                    padding: const EdgeInsets.all(30),
                                    decoration: BoxDecoration(
                                      borderRadius: BorderRadius.circular(10),
                                      color: const Color.fromRGBO(0, 51, 167, 0.8),
                                      image: DecorationImage(
                                        fit: BoxFit.cover,
                                        image: NetworkImage(
                                            "http://10.0.2.2/finalproject/admin/uploads/doctor/${mediRecDetail.docImg}",
                                            scale: 1),
                                      ),
                                    ),
                                  )
                                ],
                              ),
                            ],
                          ),
                        ),
                        const SizedBox(
                          height: 30,
                        ),
                        Container(
                          width: double.infinity,
                          padding: EdgeInsets.all(30),
                          decoration: BoxDecoration(
                              borderRadius: BorderRadius.circular(10),
                              gradient: const LinearGradient(
                                begin: Alignment.topRight,
                                end: Alignment.bottomLeft,
                                colors: [
                                  appSecThemeColor,
                                  Color.fromRGBO(0, 51, 167, 1),
                                ],
                              ),
                              image: DecorationImage(
                                fit: BoxFit.cover,
                                colorFilter: ColorFilter.mode(Colors.black.withOpacity(0.2), BlendMode.dstATop),
                                image: const AssetImage(
                                  'images/background/bg-4.jpg',
                                ),
                              )),
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.start,
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Center(
                                child: Text(
                                  "Medical Details ", // User Name will be Displayed Here
                                  style: GoogleFonts.roboto(
                                      fontStyle: FontStyle.normal,
                                      fontWeight: FontWeight.w800,
                                      fontSize: 25,
                                      color: Colors.white),
                                ),
                              ),
                              const SizedBox(
                                height: 20,
                              ),
                              Container(
                                width: c_width,
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text(
                                      "Medical Summary: ", // User Name will be Displayed Here
                                      style: GoogleFonts.roboto(
                                          fontStyle: FontStyle.normal,
                                          fontWeight: FontWeight.w700,
                                          fontSize: 16,
                                          color: Colors.white),
                                    ),
                                    Text(
                                      "${mediRecDetail.mediRecDesc}",
                                      softWrap: true, // User Name will be Displayed Here
                                      style: GoogleFonts.roboto(
                                          fontStyle: FontStyle.normal,
                                          fontWeight: FontWeight.w500,
                                          fontSize: 15,
                                          color: Colors.white),
                                    ),
                                  ],
                                ),
                              ),
                              const SizedBox(
                                height: 20,
                              ),
                              Container(
                                width: c_width,
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text(
                                      "Prescription Detail: ", // User Name will be Displayed Here
                                      style: GoogleFonts.roboto(
                                          fontStyle: FontStyle.normal,
                                          fontWeight: FontWeight.w700,
                                          fontSize: 16,
                                          color: Colors.white),
                                    ),
                                    Text(
                                      "${mediRecDetail.preDesc}",
                                      softWrap: true, // User Name will be Displayed Here
                                      style: GoogleFonts.roboto(
                                          fontStyle: FontStyle.normal,
                                          fontWeight: FontWeight.w500,
                                          fontSize: 15,
                                          color: Colors.white),
                                    ),
                                  ],
                                ),
                              ),
                              const SizedBox(
                                height: 12,
                              ),
                              Row(
                                children: [
                                  Text(
                                    "Prescription Status: ", // User Name will be Displayed Here
                                    style: GoogleFonts.roboto(
                                        fontStyle: FontStyle.normal,
                                        fontWeight: FontWeight.w700,
                                        fontSize: 16,
                                        color: Colors.white),
                                  ),
                                  if (mediRecDetail.preStatusName == "Active") ...[
                                    Container(
                                      padding: EdgeInsets.fromLTRB(10, 5, 15, 5),
                                      decoration: BoxDecoration(
                                        borderRadius: BorderRadius.circular(30),
                                        color: Colors.amber,
                                      ),
                                      child: Row(
                                        children: [
                                          const Padding(
                                            padding: const EdgeInsets.fromLTRB(5, 0, 5, 0),
                                            child: Icon(Icons.notifications_active,color: Colors.white,size: 20,),
                                          ),
                                          Text(
                                            "Pending", // User Name will be Displayed Here
                                            style: GoogleFonts.roboto(
                                                fontStyle: FontStyle.normal,
                                                fontWeight: FontWeight.w800,
                                                fontSize: 13,
                                                color: Colors.white),
                                          ),
                                        ],
                                      ),
                                    ), // Pending Tag
                                  ] else ...[
                                    Container(
                                      padding: EdgeInsets.fromLTRB(10, 5, 15, 5),
                                      decoration: BoxDecoration(
                                        borderRadius: BorderRadius.circular(30),
                                        color: const Color.fromRGBO(33, 232, 152, 1.0),
                                      ),
                                      child: Row(
                                        children: [
                                          Padding(
                                            padding: const EdgeInsets.fromLTRB(5, 0, 5, 0),
                                            child: Icon(Icons.notifications_off,color: Colors.white,size: 20,),
                                          ),
                                          Text(
                                            "Inactive", // User Name will be Displayed Here
                                            style: GoogleFonts.roboto(
                                                fontStyle: FontStyle.normal,
                                                fontWeight: FontWeight.w800,
                                                fontSize: 13,
                                                color: Colors.white),
                                          ),
                                        ],
                                      ),
                                    ),  // Done Tag
                                  ]
                                ],
                              ),
                              const SizedBox(
                                height: 15,
                              ),
                              Row(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: [
                                  TextButton(
                                      onPressed: () => Navigator.push(
                                          context,
                                          MaterialPageRoute( builder: (context) => PrescriptionDetails(precriptionID: mediRecDetail.preId))),
                                      style: ButtonStyle(
                                          foregroundColor: MaterialStateProperty.all<Color>(const Color.fromRGBO(0, 51, 167, 0.8)),
                                          backgroundColor: MaterialStateProperty.all<Color>(Colors.white),
                                          shape: MaterialStateProperty.all<RoundedRectangleBorder>(RoundedRectangleBorder(
                                              borderRadius: BorderRadius.circular(18.0)))),
                                      child: const Text("Show Prescribed Medicines"))
                                ],
                              )
                            ],
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
        ),
      ),
    );
  }
}
