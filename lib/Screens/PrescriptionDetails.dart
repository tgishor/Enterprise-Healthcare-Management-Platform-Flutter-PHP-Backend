import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:intl/intl.dart';
import 'package:provider/provider.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:smart_hrms_app/Screens/userNameLogin.dart';
import '../constants.dart';
import '../modals/all-fetch-api.dart';
import '../modals/get-loggedUserInfo.dart';
import '../modals/get-prescriptionDetail.dart';
import '../services/notification.dart';
import 'MedicineDetail.dart';
import 'package:flutter_switch/flutter_switch.dart';

import 'ViewAllMedicalRecords.dart';

var finalSessionID;

class PrescriptionDetails extends StatefulWidget {
  final String precriptionID;
  const PrescriptionDetails({Key? key, required this.precriptionID}) : super(key: key);

  @override
  State<PrescriptionDetails> createState() => _PrescriptionDetailsState();
}

class _PrescriptionDetailsState extends State<PrescriptionDetails> {

  int _itemsCounter = 0;
  bool status1 = true;
  bool status2 = true;
  bool status3 = true;
  bool status4 = true;
  bool status5 = true;
  bool status6 = true;
  bool status7 = true;
  bool status8 = false;
  bool isSwitchOn = false;

  Color _textColor = Colors.black;
  Color _appBarColor = Color.fromRGBO(36, 41, 46, 1);
  Color _scaffoldBgcolor = Colors.white;

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

    Provider.of<NotificationService>(context,listen: false).initialize();

    super.initState();
  }


  Widget customSwitch(){
    return FlutterSwitch(
      width: 65.0,
      height: 40.0,
      toggleSize: 30.0,
      value: status7,
      borderRadius: 30.0,
      padding: 2.0,
      activeToggleColor: Color(0xFF6E40C9),
      inactiveToggleColor: Color(0xFF2F363D),
      activeSwitchBorder: Border.all(
        color: Color(0xFF3C1E70),
        width: 2.0,
      ),
      inactiveSwitchBorder: Border.all(
        color: Color(0xFFD1D5DA),
        width: 2.0,
      ),
      activeColor: Color(0xFF271052),
      inactiveColor: Colors.white,
      activeIcon: const Icon(
        Icons.notifications_active,
        color: Color(0xFFF8E3A1),
      ),
      inactiveIcon: const Icon(
        Icons.notifications_off,
        color: Color(0xFFFFDF5D),
      ),
      onToggle: (val) {
        setState(() {
          status7 = val;
          if (val) {
            _textColor = Colors.white;
            _appBarColor = const Color.fromRGBO(22, 27, 34, 1);
            _scaffoldBgcolor = const Color(0xFF0D1117);
          } else {
            _textColor = Colors.black;
            _appBarColor = Color.fromRGBO(36, 41, 46, 1);
            _scaffoldBgcolor = Colors.white;
          }
        });
      },
    );
  }


  @override
  Widget build(BuildContext context) {
    return MultiProvider(
        providers: [ChangeNotifierProvider(create: (_) => NotificationService())],
        child: Scaffold(
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
                    title: const Text("Prescription Detail", style: TextStyle(color: Colors.black)),
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
                margin: const EdgeInsets.all(20),
                child: Consumer<NotificationService>(
                  builder: (context, model, _) =>
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          FutureBuilder(
                              future: fetchPrescriptionDetails(widget.precriptionID),
                              builder: (context, AsyncSnapshot<List<PrescriptionAllDetails>> snapshot) {
                                if (snapshot.hasData) {
                                  PrescriptionAllDetails preDetails = snapshot.data![0];
                                  return Column(
                                    crossAxisAlignment: CrossAxisAlignment.start,
                                    children: [
                                      const SizedBox(
                                        height: 15,
                                      ),
                                      Text(
                                        "Information", // User Name will be Displayed Here
                                        style: GoogleFonts.roboto(
                                            fontStyle: FontStyle.normal,
                                            fontWeight: FontWeight.w600,
                                            fontSize: 20,
                                            color: Colors.black),
                                      ),
                                      const SizedBox(
                                        height: 13,
                                      ),
                                      Row(
                                        children: [
                                          Text(
                                            "Prescribed Date:", // User Name will be Displayed Here
                                            style: GoogleFonts.roboto(
                                                fontStyle: FontStyle.normal,
                                                fontWeight: FontWeight.w600,
                                                fontSize: 15,
                                                color: Colors.black),
                                          ),
                                          const SizedBox(
                                            width: 6,
                                          ),
                                          Text(
                                            "${DateFormat('dd-MMM-y').format(preDetails.bookAllocateDateTime)}", // User Name will be Displayed Here
                                            style: GoogleFonts.roboto(
                                                fontStyle: FontStyle.normal,
                                                fontWeight: FontWeight.w600,
                                                fontSize: 15,
                                                color: Colors.black),
                                          ),
                                        ],
                                      ),
                                      const SizedBox(height: 8,),
                                      Row(
                                        children: [
                                          Text(
                                            "Medication Stop Date:", // User Name will be Displayed Here
                                            style: GoogleFonts.roboto(
                                                fontStyle: FontStyle.normal,
                                                fontWeight: FontWeight.w600,
                                                fontSize: 15,
                                                color: Colors.black),
                                          ),
                                          const SizedBox(
                                            width: 6,
                                          ),
                                          Text(
                                            "${DateFormat('dd-MMM-y').format(preDetails.preMedPrecribingOverDate)}", // User Name will be Displayed Here
                                            style: GoogleFonts.roboto(
                                                fontStyle: FontStyle.normal,
                                                fontWeight: FontWeight.w600,
                                                fontSize: 15,
                                                color: Colors.black),
                                          ),
                                        ],
                                      ),
                                    ],
                                  );
                                }else if (snapshot.hasError) {
                                  return Container(child: const Text('No Medical Record Details Found'));
                                  // print("No Data in the Snapshot");
                                }
                                return Container(child: const Center(child: CircularProgressIndicator(),),);
                              }
                          ),
                          const SizedBox(height: 25),
                          Text(
                            "Medicines To Take", // User Name will be Displayed Here
                            style: GoogleFonts.roboto(
                                fontStyle: FontStyle.normal, fontWeight: FontWeight.w500, fontSize: 20, color: Colors.black),
                          ),
                          const SizedBox(height: 20),
                          FutureBuilder(
                            future: fetchPrescriptionDetails(widget.precriptionID),
                            builder: (context, snapshot) {
                              if (snapshot.hasData) {
                                print(snapshot.data.toString());
                                return ListView.builder(
                                    itemCount: snapshot.data?.length,
                                    shrinkWrap: true,
                                    physics: const NeverScrollableScrollPhysics(),
                                    itemBuilder: (BuildContext context, index) {
                                      final bool status12 = true;
                                      _itemsCounter++;
                                      PrescriptionAllDetails preDetails = snapshot.data![index];
                                      return Container(
                                        child: Column(
                                          children: [
                                            Container(
                                              width: double.infinity,
                                              padding: const EdgeInsets.fromLTRB(30, 15, 30, 15),
                                              decoration: BoxDecoration(
                                                borderRadius: BorderRadius.circular(10),
                                                gradient: const LinearGradient(begin: Alignment.topRight, end: Alignment.bottomLeft, colors: [
                                                  appSecThemeColor,
                                                  Color.fromRGBO(11, 1, 187, 0.7),
                                                ]),
                                              ),
                                              child: Column(
                                                mainAxisAlignment: MainAxisAlignment.start,
                                                crossAxisAlignment: CrossAxisAlignment.start,
                                                children: [
                                                  Row(
                                                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                                    children: [
                                                      Container(
                                                        child: Column(
                                                          crossAxisAlignment: CrossAxisAlignment.start,
                                                          children: [
                                                            Container(
                                                              width: MediaQuery.of(context).size.width * 0.45,
                                                              child: Column(
                                                                crossAxisAlignment: CrossAxisAlignment.start,
                                                                children: [
                                                                  Text(
                                                                    "${preDetails.mediName}", // User Name will be Displayed Here
                                                                    style: GoogleFonts.roboto(
                                                                        fontStyle: FontStyle.normal,
                                                                        fontWeight: FontWeight.w900,
                                                                        fontSize: 20,
                                                                        color: Colors.white),
                                                                  ),
                                                                  Text(
                                                                    "(${preDetails.dTypeName})",
                                                                    softWrap: true, // User Name will be Displayed Here
                                                                    style: GoogleFonts.roboto(
                                                                        fontStyle: FontStyle.normal,
                                                                        fontWeight: FontWeight.w500,
                                                                        fontSize: 15,
                                                                        color: Colors.white),
                                                                  ),
                                                                  const SizedBox(
                                                                    height: 10,
                                                                  ),
                                                                  Text(
                                                                    "Usage Time: ${preDetails.usageTime} (${preDetails.usageNotiTime})",
                                                                    softWrap: true, // User Name will be Displayed Here
                                                                    style: GoogleFonts.roboto(
                                                                        fontStyle: FontStyle.normal,
                                                                        fontWeight: FontWeight.w700,
                                                                        fontSize: 10,
                                                                        color: Colors.white),
                                                                  ),
                                                                  const SizedBox(
                                                                    height: 5,
                                                                  ),
                                                                  Text(
                                                                    "Usage Condition: ${preDetails.medicineUsingState}",
                                                                    softWrap: true, // User Name will be Displayed Here
                                                                    style: GoogleFonts.roboto(
                                                                        fontStyle: FontStyle.normal,
                                                                        fontWeight: FontWeight.w700,
                                                                        fontSize: 10,
                                                                        color: Colors.white),
                                                                  ),
                                                                  const SizedBox(
                                                                    height: 5,
                                                                  ),
                                                                  Text(
                                                                    "Medicine Dosage: ${preDetails.doseQuantity}",
                                                                    softWrap: true, // User Name will be Displayed Here
                                                                    style: GoogleFonts.roboto(
                                                                        fontStyle: FontStyle.normal,
                                                                        fontWeight: FontWeight.w700,
                                                                        fontSize: 10,
                                                                        color: Colors.white),
                                                                  ),
                                                                  const Divider(color: Colors.white,),
                                                                  Text(
                                                                    "Use for: ",
                                                                    softWrap: true, // User Name will be Displayed Here
                                                                    style: GoogleFonts.roboto(
                                                                        fontStyle: FontStyle.normal,
                                                                        fontWeight: FontWeight.w700,
                                                                        fontSize: 10,
                                                                        color: Colors.white),
                                                                  ),
                                                                  const SizedBox(
                                                                    height: 5,
                                                                  ),
                                                                  Text(
                                                                    "${DateFormat('dd-MMM-y').format(preDetails.preMedPrecribingDate)} to ${DateFormat('dd-MMM-y').format(preDetails.preMedPrecribingOverDate)} (${(preDetails.preMedPrecribingOverDate).difference(preDetails.preMedPrecribingDate).inDays} Days)",
                                                                    softWrap: true, // User Name will be Displayed Here
                                                                    style: GoogleFonts.roboto(
                                                                        fontStyle: FontStyle.normal,
                                                                        fontWeight: FontWeight.w700,
                                                                        fontSize: 10,
                                                                        color: Colors.white),
                                                                  ),
                                                                  const SizedBox(
                                                                    height: 5,
                                                                  ),
                                                                  Row(
                                                                    mainAxisAlignment: MainAxisAlignment.start,
                                                                    children: [
                                                                      TextButton(
                                                                          onPressed: () => Navigator.push(
                                                                              context,
                                                                              MaterialPageRoute( builder: (context) => MedicalDetailScreen(medicine_id: "${preDetails.mediId}") )),
                                                                          style: ButtonStyle(
                                                                              foregroundColor:
                                                                              MaterialStateProperty.all<Color>(const Color.fromRGBO(0, 51, 167, 0.8)),
                                                                              backgroundColor: MaterialStateProperty.all<Color>(Colors.white),
                                                                              shape: MaterialStateProperty.all<RoundedRectangleBorder>(
                                                                                  RoundedRectangleBorder(
                                                                                      borderRadius: BorderRadius.circular(10.0)))),
                                                                          child: const Padding(
                                                                            padding: EdgeInsets.fromLTRB(10, 0, 10, 0),
                                                                            child: Text(
                                                                              "Show More",
                                                                              style: TextStyle(fontSize: 11, fontWeight: FontWeight.w800),
                                                                            ),
                                                                          )),
                                                                      SizedBox(width: 10,),
                                                                      FlutterSwitch(
                                                                        width: 65.0,
                                                                        height: 40.0,
                                                                        toggleSize: 30.0,
                                                                        value: status7,
                                                                        borderRadius: 30.0,
                                                                        padding: 2.0,
                                                                        activeToggleColor: Color(0xFF6E40C9),
                                                                        inactiveToggleColor: Color(0xFF2F363D),
                                                                        activeSwitchBorder: Border.all(
                                                                          color: Color(0xFF3C1E70),
                                                                          width: 2.0,
                                                                        ),
                                                                        inactiveSwitchBorder: Border.all(
                                                                          color: Color(0xFFD1D5DA),
                                                                          width: 2.0,
                                                                        ),
                                                                        activeColor: Color(0xFF271052),
                                                                        inactiveColor: Colors.white,
                                                                        activeIcon: const Icon(
                                                                          Icons.notifications_active,
                                                                          color: Color(0xFFF8E3A1),
                                                                        ),
                                                                        inactiveIcon: const Icon(
                                                                          Icons.notifications_off,
                                                                          color: Color(0xFFFFDF5D),
                                                                        ),
                                                                        onToggle: (val) {
                                                                          setState(() {
                                                                            status7 = val;
                                                                            if (val) {
                                                                              _textColor = Colors.white;
                                                                              _appBarColor = const Color.fromRGBO(22, 27, 34, 1);
                                                                              _scaffoldBgcolor = const Color(0xFF0D1117);
                                                                              model.instantNotification('2','Its time for tablet intake now...!!\nMedicine name: Cofsils');
                                                                            } else {
                                                                              _textColor = Colors.black;
                                                                              _appBarColor = Color.fromRGBO(36, 41, 46, 1);
                                                                              _scaffoldBgcolor = Colors.white;
                                                                              model.instantNotification('2','Its time for tablet intake now...!!\nMedicine name: Cofsils');
                                                                              print('Notificatio OFF');
                                                                            }
                                                                          });
                                                                        },
                                                                      ),
                                                                    ],
                                                                  ),
                                                                  // Row(
                                                                  //   mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                                                  //   children: <Widget>[
                                                                  //
                                                                  //     Container(
                                                                  //       alignment: Alignment.centerRight,
                                                                  //       child: Text("Value: $status7"),
                                                                  //     ),
                                                                  //   ],
                                                                  // )
                                                                ],
                                                              ),
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
                                                        height: 120,
                                                        padding: const EdgeInsets.all(30),
                                                        decoration: BoxDecoration(
                                                          borderRadius: BorderRadius.circular(10),
                                                          image: DecorationImage(
                                                            fit: BoxFit.cover,
                                                            image: NetworkImage(
                                                                "http://10.0.2.2/finalproject/admin/uploads/medicine/frontimage/${preDetails.mediFrontImg}",
                                                                scale: 1),
                                                          ),
                                                        ),
                                                      )
                                                    ],
                                                  ),
                                                ],
                                              ),
                                            ),
                                            const SizedBox(height: 20),
                                          ],
                                        ),
                                      );
                                    });
                              } else if (snapshot.hasError) {
                                return Container(child: const Text('No Medical Records Found'));
                              }
                              return const CircularProgressIndicator();
                            },
                          ),
                        ],
                      ),
                ),
              ),
            ),
          ),
        )
    );
  }
}
