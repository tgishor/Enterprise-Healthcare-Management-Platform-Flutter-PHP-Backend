import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:intl/intl.dart';
import 'package:material_floating_search_bar/material_floating_search_bar.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:smart_hrms_app/Screens/PrescriptionDetails.dart';
import '../constants.dart';
import '../modals/all-fetch-api.dart';
import '../modals/get-loggedUserInfo.dart';
import '../modals/get-patientHasDisease.dart';
import '../modals/get-prescriptionHistory.dart';
import 'userNameLogin.dart';

var finalSessionID;

class PrescriptionHistory extends StatefulWidget {
  const PrescriptionHistory({Key? key}) : super(key: key);

  @override
  State<PrescriptionHistory> createState() => _PrescriptionHistoryState();
}

class _PrescriptionHistoryState extends State<PrescriptionHistory> with TickerProviderStateMixin {
  late AnimationController _controller;

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
      () => Get.to(finalSessionID == null ? const applicationNew() : const PrescriptionHistory());
    });
    super.initState();
    _controller = AnimationController(vsync: this);
  }

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    TabController _tabController = TabController(length: 2, vsync: this);

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
                    padding: const EdgeInsets.fromLTRB(0, 0, 20, 0),
                    child: CircleAvatar(
                      backgroundImage:
                          NetworkImage("http://10.0.2.2/finalproject/admin/uploads/patient/${loggedUserDetails.pImg}"),
                    ),
                  ),
                ],
                title: const Text("Prescription History", style: TextStyle(color: Colors.black)),
              );
            } else if (snapshot.hasError) {
              return Container(child: const Text('No Medical Records Found'));
            }
            return const CircularProgressIndicator();
          },
        ),
      ),
      body: Stack(
        fit: StackFit.expand,
        children: [
          Container(
            margin: const EdgeInsets.fromLTRB(25, 90, 25, 0),
            child: Column(
              children: [
                Container(
                  child: Align(
                    alignment: Alignment.centerLeft,
                    child: TabBar(
                      controller: _tabController,
                      isScrollable: true,
                      labelColor: const Color.fromRGBO(42, 42, 192, 1),
                      labelStyle: const TextStyle(fontWeight: FontWeight.w600),
                      unselectedLabelColor: Colors.grey,
                      indicatorColor: const Color.fromRGBO(42, 42, 192, 1),
                      tabs: const [
                        Tab(
                          text: "Active",
                        ),
                        Tab(
                          text: "Inactive",
                        ),
                      ],
                    ),
                  ),
                ),
                const Divider(
                  thickness: 2,
                ),
                Container(
                  width: double.maxFinite,
                  height: 500,
                  child: TabBarView(
                    controller: _tabController,
                    children: [
                      FutureBuilder(
                        future: fetchPresHistoryAll("${patientID}", "Active"),
                        builder: (context, snapshot) {
                          if (snapshot.hasData) {
                            print(snapshot.data.toString());
                            return ListView.builder(
                                itemCount: snapshot.data?.length,
                                shrinkWrap: true,
                                itemBuilder: (BuildContext context, index) {
                                  PrescriptAllHistory preHisDetails = snapshot.data![index];
                                  return Container(
                                    child: Column(
                                      crossAxisAlignment: CrossAxisAlignment.start,
                                      children: [
                                        Container(
                                            padding: const EdgeInsets.all(10),
                                            child: Row(
                                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                              children: [
                                                Column(
                                                  crossAxisAlignment: CrossAxisAlignment.start,
                                                  children: [
                                                    Text(
                                                      "Prescribed Date: ${DateFormat('dd-MMM-y').format(preHisDetails.bookAllocateDateTime)}",
                                                      style: GoogleFonts.roboto(
                                                          fontStyle: FontStyle.normal,
                                                          fontWeight: FontWeight.w500,
                                                          fontSize: 13,
                                                          color: Colors.black87),
                                                    ),
                                                    const SizedBox(
                                                      height: 5,
                                                    ),
                                                    Container(
                                                      width: MediaQuery.of(context).size.width * 0.5,
                                                      child: Column(
                                                        crossAxisAlignment: CrossAxisAlignment.start,
                                                        children: [
                                                          Text(
                                                            "Prescribed By: ${preHisDetails.docName}",
                                                            style: GoogleFonts.roboto(
                                                                fontStyle: FontStyle.normal,
                                                                fontWeight: FontWeight.w800,
                                                                fontSize: 15,
                                                                color: Colors.black),
                                                          ),
                                                          Divider(color: Colors.black54,),
                                                          Text(
                                                            "Recorded Diseases: ",
                                                            style: GoogleFonts.roboto(
                                                                fontStyle: FontStyle.normal,
                                                                fontWeight: FontWeight.w800,
                                                                fontSize: 15,
                                                                color: Colors.black),
                                                          ),
                                                          FutureBuilder(
                                                            future: fetchPatientHasDisease(patientID,
                                                                "${DateFormat('yyyy-M-dd').format(preHisDetails.bookDateTime)}"),
                                                            builder: (context, snapshot) {
                                                              if (snapshot.hasData) {
                                                                print(snapshot.data.toString());
                                                                return ListView.builder(
                                                                    itemCount: snapshot.data?.length,
                                                                    shrinkWrap: true,
                                                                    itemBuilder: (BuildContext context, index) {
                                                                      PatientDiseaseDetail patientDisease =
                                                                      snapshot.data![index];
                                                                      return Row(
                                                                        children: [
                                                                          Text(
                                                                            "${patientDisease.disName}",
                                                                            style: GoogleFonts.roboto(
                                                                                fontStyle: FontStyle.normal,
                                                                                fontWeight: FontWeight.w600,
                                                                                fontSize: 15,
                                                                                color: Colors.black),
                                                                          ),
                                                                        ],
                                                                      );
                                                                    });
                                                              } else if (snapshot.hasError) {
                                                                return Container(child: const Text('No Appointments Found'));
                                                                // print("No Data in the Snapshot");
                                                              }
                                                              return const CircularProgressIndicator();
                                                            },
                                                          )
                                                        ],
                                                      ),
                                                    ),
                                                  ],
                                                ),
                                                TextButton(
                                                    onPressed: () => Navigator.push(
                                                      context,
                                                      MaterialPageRoute(
                                                          builder: (context) => PrescriptionDetails(precriptionID: preHisDetails.preId)
                                                      ),
                                                    ),
                                                    style: ButtonStyle(
                                                        foregroundColor: MaterialStateProperty.all<Color>(Colors.white),
                                                        backgroundColor: MaterialStateProperty.all<Color>(
                                                            const Color.fromRGBO(0, 51, 167, 0.8)),
                                                        shape: MaterialStateProperty.all<RoundedRectangleBorder>(
                                                            RoundedRectangleBorder(
                                                                borderRadius: BorderRadius.circular(10.0)))),
                                                    child: const Padding(
                                                      padding: EdgeInsets.fromLTRB(15, 0, 15, 0),
                                                      child: Text(
                                                        "Show Details",
                                                        style: TextStyle(fontSize: 11, fontWeight: FontWeight.w800),
                                                      ),
                                                    )),
                                              ],
                                            )),
                                        const Divider(
                                          thickness: 2,
                                        ),
                                      ],
                                    ),
                                  );
                                });
                          } else if (snapshot.hasError) {
                            return Container(child: const Center(child: Text('No Prescription Records Found')));
                          }
                          return const CircularProgressIndicator();
                        },
                      ),
                      FutureBuilder(
                        future: fetchPresHistoryAll("${patientID}", "Inactive"),
                        builder: (context, snapshot) {
                          if (snapshot.hasData) {
                            print(snapshot.data.toString());
                            return ListView.builder(
                                itemCount: snapshot.data?.length,
                                shrinkWrap: true,
                                itemBuilder: (BuildContext context, index) {
                                  PrescriptAllHistory preHisDetails = snapshot.data![index];
                                  return Container(
                                    child: Column(
                                      crossAxisAlignment: CrossAxisAlignment.start,
                                      children: [
                                        Container(
                                            padding: const EdgeInsets.all(10),
                                            child: Row(
                                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                              children: [
                                                Column(
                                                  crossAxisAlignment: CrossAxisAlignment.start,
                                                  children: [
                                                    Text(
                                                      "Prescribed Date: ${DateFormat('dd-MMM-y').format(preHisDetails.bookAllocateDateTime)}",
                                                      style: GoogleFonts.roboto(
                                                          fontStyle: FontStyle.normal,
                                                          fontWeight: FontWeight.w500,
                                                          fontSize: 13,
                                                          color: Colors.black87),
                                                    ),
                                                    const SizedBox(
                                                      height: 5,
                                                    ),
                                                    Container(
                                                      width: MediaQuery.of(context).size.width * 0.5,
                                                      child: Column(
                                                        crossAxisAlignment: CrossAxisAlignment.start,
                                                        children: [
                                                          Text(
                                                            "Prescribed By: ${preHisDetails.docName}",
                                                            style: GoogleFonts.roboto(
                                                                fontStyle: FontStyle.normal,
                                                                fontWeight: FontWeight.w800,
                                                                fontSize: 15,
                                                                color: Colors.black),
                                                          ),
                                                          Divider(color: Colors.black54,),
                                                          Text(
                                                            "Recorded Diseases: ",
                                                            style: GoogleFonts.roboto(
                                                                fontStyle: FontStyle.normal,
                                                                fontWeight: FontWeight.w800,
                                                                fontSize: 15,
                                                                color: Colors.black),
                                                          ),
                                                          FutureBuilder(
                                                            future: fetchPatientHasDisease(patientID,
                                                                "${DateFormat('yyyy-M-dd').format(preHisDetails.bookDateTime)}"),
                                                            builder: (context, snapshot) {
                                                              if (snapshot.hasData) {
                                                                print(snapshot.data.toString());
                                                                return ListView.builder(
                                                                    itemCount: snapshot.data?.length,
                                                                    shrinkWrap: true,
                                                                    itemBuilder: (BuildContext context, index) {
                                                                      PatientDiseaseDetail patientDisease =
                                                                      snapshot.data![index];
                                                                      return Row(
                                                                        children: [
                                                                          Text(
                                                                            "${patientDisease.disName}",
                                                                            style: GoogleFonts.roboto(
                                                                                fontStyle: FontStyle.normal,
                                                                                fontWeight: FontWeight.w600,
                                                                                fontSize: 15,
                                                                                color: Colors.black),
                                                                          ),
                                                                        ],
                                                                      );
                                                                    });
                                                              } else if (snapshot.hasError) {
                                                                return Container(child: const Text('No Appointments Found'));
                                                                // print("No Data in the Snapshot");
                                                              }
                                                              return const CircularProgressIndicator();
                                                            },
                                                          )
                                                        ],
                                                      ),
                                                    ),
                                                  ],
                                                ),
                                                TextButton(
                                                    onPressed: () => Navigator.push(
                                                      context,
                                                      MaterialPageRoute(
                                                          builder: (context) => PrescriptionDetails(precriptionID: preHisDetails.preId)
                                                      ),
                                                    ),
                                                    style: ButtonStyle(
                                                        foregroundColor: MaterialStateProperty.all<Color>(Colors.white),
                                                        backgroundColor: MaterialStateProperty.all<Color>(
                                                            const Color.fromRGBO(0, 51, 167, 0.8)),
                                                        shape: MaterialStateProperty.all<RoundedRectangleBorder>(
                                                            RoundedRectangleBorder(
                                                                borderRadius: BorderRadius.circular(10.0)))),
                                                    child: const Padding(
                                                      padding: EdgeInsets.fromLTRB(15, 0, 15, 0),
                                                      child: Text(
                                                        "Show Details",
                                                        style: TextStyle(fontSize: 11, fontWeight: FontWeight.w800),
                                                      ),
                                                    )),
                                              ],
                                            )),
                                        const Divider(
                                          thickness: 2,
                                        ),
                                      ],
                                    ),
                                  );
                                });
                          } else if (snapshot.hasError) {
                            return Container(child: const Center(child: Text('No Prescription Records Found')));
                          }
                          return const CircularProgressIndicator();
                        },
                      ),
                    ],
                  ),
                )
              ],
            ),
          ),
          searchBarUI()
        ],
      ),
    );
  }
}

Widget searchBarUI() {
  return FloatingSearchBar(
    hint: 'Search.....',
    openAxisAlignment: 0.0,
    openWidth: 600,
    axisAlignment: 0.0,
    scrollPadding: const EdgeInsets.only(top: 16, bottom: 20),
    elevation: 4.0,
    physics: const BouncingScrollPhysics(),
    automaticallyImplyBackButton: false,
    onQueryChanged: (query) {
      //Your methods will be here
    },
    transitionCurve: Curves.easeInOut,
    transitionDuration: const Duration(milliseconds: 500),
    transition: CircularFloatingSearchBarTransition(),
    debounceDelay: const Duration(milliseconds: 500),
    actions: [
      FloatingSearchBarAction(
        showIfOpened: false,
        child: CircularButton(
          icon: const Icon(Icons.search),
          onPressed: () {
            print('Places Pressed');
          },
        ),
      ),
      FloatingSearchBarAction.searchToClear(
        showIfClosed: false,
      ),
    ],
    builder: (context, transition) {
      return ClipRRect(
        borderRadius: BorderRadius.circular(8.0),
        child: Material(
          color: Colors.white,
          child: Container(
            height: 200.0,
            color: Colors.white,
            child: Column(
              children: [
                ListTile(
                  title: const Text('Home'),
                  subtitle: const Text('more info here........'),
                  onTap: () => print('Hello World'),
                ),
              ],
            ),
          ),
        ),
      );
    },
  );
}
