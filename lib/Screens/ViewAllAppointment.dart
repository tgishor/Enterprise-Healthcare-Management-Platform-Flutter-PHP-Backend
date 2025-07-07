import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:intl/intl.dart';
import 'package:material_floating_search_bar/material_floating_search_bar.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:smart_hrms_app/Screens/RequestAppoinment.dart';
import 'package:smart_hrms_app/Screens/userNameLogin.dart';
import '../constants.dart';
import '../modals/all-fetch-api.dart';
import '../modals/get-appointmentHistory.dart';
import '../modals/get-loggedUserInfo.dart';
import 'ViewAllMedicalRecords.dart';

var finalSessionID;

class ViewAllAppointment extends StatefulWidget {
  const ViewAllAppointment({Key? key}) : super(key: key);

  @override
  State<ViewAllAppointment> createState() => _ViewAllAppointmentState();
}

class _ViewAllAppointmentState extends State<ViewAllAppointment> with TickerProviderStateMixin {
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
          () => Get.to(finalSessionID == null ? applicationNew() : ViewAllAppointment());
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
      backgroundColor: Color.fromRGBO(236, 241, 250, 1),
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
                title: const Text("Appointment History", style: TextStyle(color: Colors.black)),
              );
            } else if (snapshot.hasError) {
              return Container(child: Text('No Medical Records Found'));
            }
            return CircularProgressIndicator();
          },
        ),
      ),

      body: Stack(
        fit: StackFit.expand,
        children: [
          Container(
            margin: EdgeInsets.fromLTRB(25, 75, 25, 0),
            child: SingleChildScrollView(
              child: Column(
                children: [
                  TextButton(
                      onPressed: () => Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => const RequestAppointment()),
                      ),
                      child: Padding(
                        padding: EdgeInsets.fromLTRB(15,0,15,0),
                        child: Text("Request Appointment", style: TextStyle(fontSize: 13, fontWeight: FontWeight.w800),),
                      ),
                      style: ButtonStyle(
                          foregroundColor: MaterialStateProperty.all<Color>(Color.fromRGBO(0, 51, 167, 0.8)),
                          backgroundColor: MaterialStateProperty.all<Color>(Colors.white),
                          shape: MaterialStateProperty.all<RoundedRectangleBorder>(RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(10.0))))),
                  SizedBox(height: 5,),
                  Container(
                    child: Align(
                      alignment: Alignment.centerLeft,
                      child: TabBar(
                        controller: _tabController,
                        isScrollable: true,
                        labelColor: Color.fromRGBO(42, 42, 192, 1),
                        labelStyle: TextStyle(fontWeight: FontWeight.w600),
                        unselectedLabelColor: Colors.grey,
                        indicatorColor: Color.fromRGBO(42, 42, 192, 1),
                        tabs: const [
                          Tab(
                            text: "Today",
                          ),
                          Tab(
                            text: "All Apppointment",
                          ),
                        ],
                      ),
                    ),
                  ),
                  SingleChildScrollView(
                    child: Container(
                      width: double.maxFinite,
                      height: 500,
                      child: TabBarView(
                        controller: _tabController,
                        children: [
                          FutureBuilder(
                            future: fetchTodayAppointments("${patientID}"),
                            builder: (context, snapshot) {
                              if (snapshot.hasData) {
                                print(snapshot.data.toString());
                                return ListView.builder(
                                    itemCount: snapshot.data?.length,
                                    shrinkWrap: true,
                                    itemBuilder: (BuildContext context, index) {
                                      AppointmentHistory appointmentHis = snapshot.data![index];
                                      return Column(
                                        children: [
                                          const SizedBox(
                                            height: 15,
                                          ),
                                          Container(
                                            width: double.infinity,
                                            padding: EdgeInsets.fromLTRB(30, 15, 30, 15),
                                            decoration: BoxDecoration(
                                              borderRadius: BorderRadius.circular(10),
                                              color: const Color.fromRGBO(0, 51, 167, 0.8),
                                            ),
                                            child: Row(
                                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                              children: [
                                                Column(
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
                                                                width: MediaQuery.of(context).size.width * 0.4,
                                                                child: Column(
                                                                  crossAxisAlignment: CrossAxisAlignment.start,
                                                                  children: [
                                                                    Text(
                                                                      "${appointmentHis.docName}", // User Name will be Displayed Here
                                                                      style: GoogleFonts.roboto(
                                                                          fontStyle: FontStyle.normal,
                                                                          fontWeight: FontWeight.w900,
                                                                          fontSize: 20,
                                                                          color: Colors.white),
                                                                    ),
                                                                    const SizedBox(
                                                                      height: 10,
                                                                    ),
                                                                  ],
                                                                ),
                                                              ),
                                                              Text(
                                                                "Appointment Date: ${DateFormat('dd-MMM-y').format(appointmentHis.bookAllocateDateTime)}",
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
                                                                "Appointment Time: ${DateFormat.jm().format(appointmentHis.bookAllocateDateTime)}",
                                                                softWrap: true, // User Name will be Displayed Here
                                                                style: GoogleFonts.roboto(
                                                                    fontStyle: FontStyle.normal,
                                                                    fontWeight: FontWeight.w700,
                                                                    fontSize: 10,
                                                                    color: Colors.white),
                                                              ),
                                                            ],
                                                          ),
                                                        ),
                                                      ],
                                                    ),
                                                  ],
                                                ),
                                                TextButton(
                                                    onPressed: () => Navigator.push(
                                                      context,
                                                      MaterialPageRoute(builder: (context) => ViewAllMedicalRecords()),
                                                    ),
                                                    child: Padding(
                                                      padding: EdgeInsets.fromLTRB(15, 0, 15, 0),
                                                      child: Text(
                                                        "View Details",
                                                        style: TextStyle(fontSize: 11, fontWeight: FontWeight.w800),
                                                      ),
                                                    ),
                                                    style: ButtonStyle(
                                                        foregroundColor: MaterialStateProperty.all<Color>(
                                                            Color.fromRGBO(0, 51, 167, 0.8)),
                                                        backgroundColor: MaterialStateProperty.all<Color>(Colors.white),
                                                        shape: MaterialStateProperty.all<RoundedRectangleBorder>(
                                                            RoundedRectangleBorder(
                                                                borderRadius: BorderRadius.circular(10.0)
                                                            )
                                                        )
                                                    )
                                                )
                                              ],
                                            ),
                                          ),
                                        ],
                                      );
                                    });
                              } else if (snapshot.hasError) {
                                return Container(child: Center(child: Text('No Appointments Found Today')));
                                // print("No Data in the Snapshot");
                              }
                              return CircularProgressIndicator();
                            },
                          ),
                          FutureBuilder(
                            future: fetchAppointmentHistory("${patientID}"),
                            builder: (context, snapshot) {
                              if (snapshot.hasData) {
                                print(snapshot.data.toString());
                                return ListView.builder(
                                    itemCount: snapshot.data?.length,
                                    shrinkWrap: true,
                                    itemBuilder: (BuildContext context, index) {
                                      AppointmentHistory appointmentHis = snapshot.data![index];
                                      return Column(
                                        children: [
                                          const SizedBox(
                                            height: 15,
                                          ),
                                          Container(
                                            width: double.infinity,
                                            padding: EdgeInsets.fromLTRB(30, 15, 30, 15),
                                            decoration: BoxDecoration(
                                              borderRadius: BorderRadius.circular(10),
                                              color: const Color.fromRGBO(0, 51, 167, 0.8),
                                            ),
                                            child: Row(
                                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                              children: [
                                                Column(
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
                                                                width: MediaQuery.of(context).size.width * 0.4,
                                                                child: Column(
                                                                  crossAxisAlignment: CrossAxisAlignment.start,
                                                                  children: [
                                                                    Text(
                                                                      "${appointmentHis.docName}", // User Name will be Displayed Here
                                                                      style: GoogleFonts.roboto(
                                                                          fontStyle: FontStyle.normal,
                                                                          fontWeight: FontWeight.w900,
                                                                          fontSize: 20,
                                                                          color: Colors.white),
                                                                    ),
                                                                    const SizedBox(
                                                                      height: 10,
                                                                    ),
                                                                  ],
                                                                ),
                                                              ),
                                                              Text(
                                                                "Appointment Date: ${DateFormat('dd-MMM-y').format(appointmentHis.bookAllocateDateTime)}",
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
                                                                "Appointment Time: ${DateFormat.jm().format(appointmentHis.bookAllocateDateTime)}",
                                                                softWrap: true, // User Name will be Displayed Here
                                                                style: GoogleFonts.roboto(
                                                                    fontStyle: FontStyle.normal,
                                                                    fontWeight: FontWeight.w700,
                                                                    fontSize: 10,
                                                                    color: Colors.white),
                                                              ),
                                                            ],
                                                          ),
                                                        ),
                                                      ],
                                                    ),
                                                  ],
                                                ),
                                                TextButton(
                                                    onPressed: () => Navigator.push(
                                                      context,
                                                      MaterialPageRoute(builder: (context) => ViewAllMedicalRecords()),
                                                    ),
                                                    child: Padding(
                                                      padding: EdgeInsets.fromLTRB(15, 0, 15, 0),
                                                      child: Text(
                                                        "View Details",
                                                        style: TextStyle(fontSize: 11, fontWeight: FontWeight.w800),
                                                      ),
                                                    ),
                                                    style: ButtonStyle(
                                                        foregroundColor: MaterialStateProperty.all<Color>(
                                                            Color.fromRGBO(0, 51, 167, 0.8)),
                                                        backgroundColor: MaterialStateProperty.all<Color>(Colors.white),
                                                        shape: MaterialStateProperty.all<RoundedRectangleBorder>(
                                                            RoundedRectangleBorder(
                                                                borderRadius: BorderRadius.circular(10.0)
                                                            )
                                                        )
                                                    )
                                                )
                                              ],
                                            ),
                                          ),
                                        ],
                                      );
                                    });
                              } else if (snapshot.hasError) {
                                return Container(child: Text('No Appointments Found'));
                                // print("No Data in the Snapshot");
                              }
                              return CircularProgressIndicator();
                            },
                          ),
                        ],
                      ),
                    ),
                  )
                ],
              ),
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
    scrollPadding: EdgeInsets.only(top: 16, bottom: 20),
    elevation: 4.0,
    physics: BouncingScrollPhysics(),
    automaticallyImplyBackButton: false,
    onQueryChanged: (query) {
      //Your methods will be here
    },
    transitionCurve: Curves.easeInOut,
    transitionDuration: Duration(milliseconds: 500),
    transition: CircularFloatingSearchBarTransition(),
    debounceDelay: Duration(milliseconds: 500),
    actions: [
      FloatingSearchBarAction(
        showIfOpened: false,
        child: CircularButton(
          icon: Icon(Icons.search),
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
                  title: Text('Home'),
                  subtitle: Text('more info here........'),
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
