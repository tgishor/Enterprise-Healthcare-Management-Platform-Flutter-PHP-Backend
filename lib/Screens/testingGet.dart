import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:cupertino_icons/cupertino_icons.dart';
import 'dart:async';
import '../constants.dart';
import '../mysql.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:http/http.dart' as http;

class TestingGet extends StatefulWidget {
  const TestingGet({Key? key}) : super(key: key);

  @override
  State<TestingGet> createState() => _TestingGetState();
}

class _TestingGetState extends State<TestingGet> {
  String data = "";
  late Map mapres;
  late List listres = [];
  Future apicall() async {
    http.Response response;
    response = await http.get(Uri.parse("http://10.0.2.2/finalproject/admin/mobile-app-scripts/get-admin.php"));
    if (response.statusCode == 200) {
      setState(() {
        listres = jsonDecode(response.body);
        /*listres = mapres['data'];*/
      });
    }
  }

  void initState() {
    apicall();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
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
        title: const Text("Medical Records", style: TextStyle(color: Colors.black)),
      ),
      body: Column(
        children: [
          ListView.builder(
            scrollDirection: Axis.vertical,
            shrinkWrap: true,
            itemBuilder: (context, index) {
              return Container(
                child: Column(
                  children: [
                    SingleChildScrollView(
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.spaceAround,
                        children: [
                          Text(listres[index]['p_id'].toString()),
                          Expanded(
                            child: Column(
                              children: [
                                Text(listres[index]['p_name'].toString()),
                                Text(listres[index]['p_nic'].toString()),
                                Text(listres[index]['p_email'].toString()),
                              ],
                            ),
                          ),
                        ],
                      ),
                    )
                  ],
                ),
              );
            },
            itemCount: listres.length,
          ),

          TextButton( onPressed: apicall, child: Text("Fetch data"), ),
        ],
      ),
      backgroundColor: appBgDefault,
    );
  }
}
