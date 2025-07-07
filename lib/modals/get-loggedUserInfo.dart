// To parse this JSON data, do
//
//     final loggedUserInfo = loggedUserInfoFromJson(jsonString);

import 'package:meta/meta.dart';
import 'dart:convert';

List<LoggedUserInfo> loggedUserInfoFromJson(String str) => List<LoggedUserInfo>.from(json.decode(str).map((x) => LoggedUserInfo.fromJson(x)));

String loggedUserInfoToJson(List<LoggedUserInfo> data) => json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class LoggedUserInfo {
  LoggedUserInfo({
    required this.pId,
    required this.pName,
    required this.pNic,
    required this.pRegDate,
    required this.pDob,
    required this.pImg,
    required this.pContact,
    required this.pConOtp,
    required this.pEmail,
    required this.pEmailVeriLink,
    required this.pEmailVerStatus,
    required this.pUsername,
    required this.pPassword,
    required this.genderFk,
    required this.pAddress,
  });

  String pId;
  String pName;
  String pNic;
  DateTime pRegDate;
  DateTime pDob;
  String pImg;
  String pContact;
  dynamic pConOtp;
  String pEmail;
  String pEmailVeriLink;
  String pEmailVerStatus;
  String pUsername;
  String pPassword;
  String genderFk;
  String pAddress;

  factory LoggedUserInfo.fromJson(Map<String, dynamic> json) => LoggedUserInfo(
    pId: json["p_id"],
    pName: json["p_name"],
    pNic: json["p_nic"],
    pRegDate: DateTime.parse(json["p_regDate"]),
    pDob: DateTime.parse(json["p_dob"]),
    pImg: json["p_img"],
    pContact: json["p_contact"],
    pConOtp: json["p_conOTP"],
    pEmail: json["p_email"],
    pEmailVeriLink: json["p_emailVeriLink"],
    pEmailVerStatus: json["p_emailVerStatus"],
    pUsername: json["p_username"],
    pPassword: json["p_password"],
    genderFk: json["gender_fk"],
    pAddress: json["p_address"],
  );

  Map<String, dynamic> toJson() => {
    "p_id": pId,
    "p_name": pName,
    "p_nic": pNic,
    "p_regDate": pRegDate.toIso8601String(),
    "p_dob": "${pDob.year.toString().padLeft(4, '0')}-${pDob.month.toString().padLeft(2, '0')}-${pDob.day.toString().padLeft(2, '0')}",
    "p_img": pImg,
    "p_contact": pContact,
    "p_conOTP": pConOtp,
    "p_email": pEmail,
    "p_emailVeriLink": pEmailVeriLink,
    "p_emailVerStatus": pEmailVerStatus,
    "p_username": pUsername,
    "p_password": pPassword,
    "gender_fk": genderFk,
    "p_address": pAddress,
  };
}
