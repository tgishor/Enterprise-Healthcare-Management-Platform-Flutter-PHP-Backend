// To parse this JSON data, do
//
//     final appointmentHistory = appointmentHistoryFromJson(jsonString);

import 'package:meta/meta.dart';
import 'dart:convert';

List<AppointmentHistory> appointmentHistoryFromJson(String str) => List<AppointmentHistory>.from(json.decode(str).map((x) => AppointmentHistory.fromJson(x)));

String appointmentHistoryToJson(List<AppointmentHistory> data) => json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class AppointmentHistory {
  AppointmentHistory({
    required this.bookId,
    required this.bookDesc,
    required this.bookDateTime,
    required this.bookAllocateDateTime,
    required this.pIdFk,
    required this.staffIdFk,
    required this.docIdFk,
    required this.hosIdFk,
    required this.bookStatusIdFk,
    required this.bookStatusId,
    required this.bookStatusName,
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
    required this.docId,
    required this.docName,
    required this.docContact,
    required this.docMediLicenseNo,
    required this.specilist,
    required this.disCatIdFk,
    required this.docUsername,
    required this.docPassword,
    required this.admIdFk,
    required this.docImg,
  });

  String bookId;
  String bookDesc;
  DateTime bookDateTime;
  DateTime bookAllocateDateTime;
  String pIdFk;
  String staffIdFk;
  String docIdFk;
  String hosIdFk;
  String bookStatusIdFk;
  String bookStatusId;
  String bookStatusName;
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
  String docId;
  String docName;
  String docContact;
  String docMediLicenseNo;
  String specilist;
  String disCatIdFk;
  String docUsername;
  String docPassword;
  String admIdFk;
  String docImg;

  factory AppointmentHistory.fromJson(Map<String, dynamic> json) => AppointmentHistory(
    bookId: json["book_id"],
    bookDesc: json["book_desc"],
    bookDateTime: DateTime.parse(json["book_dateTime"]),
    bookAllocateDateTime: DateTime.parse(json["book_allocateDateTime"]),
    pIdFk: json["p_id_fk"],
    staffIdFk: json["staff_id_fk"],
    docIdFk: json["doc_id_fk"],
    hosIdFk: json["hos_id_fk"],
    bookStatusIdFk: json["bookStatus_id_fk"],
    bookStatusId: json["bookStatus_id"],
    bookStatusName: json["bookStatus_name"],
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
    docId: json["doc_id"],
    docName: json["doc_name"],
    docContact: json["doc_contact"],
    docMediLicenseNo: json["doc_mediLicenseNo"],
    specilist: json["specilist"],
    disCatIdFk: json["disCat_id_fk"],
    docUsername: json["doc_username"],
    docPassword: json["doc_password"],
    admIdFk: json["adm_id_fk"],
    docImg: json["doc_img"],
  );

  Map<String, dynamic> toJson() => {
    "book_id": bookId,
    "book_desc": bookDesc,
    "book_dateTime": bookDateTime.toIso8601String(),
    "book_allocateDateTime": bookAllocateDateTime.toIso8601String(),
    "p_id_fk": pIdFk,
    "staff_id_fk": staffIdFk,
    "doc_id_fk": docIdFk,
    "hos_id_fk": hosIdFk,
    "bookStatus_id_fk": bookStatusIdFk,
    "bookStatus_id": bookStatusId,
    "bookStatus_name": bookStatusName,
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
    "doc_id": docId,
    "doc_name": docName,
    "doc_contact": docContact,
    "doc_mediLicenseNo": docMediLicenseNo,
    "specilist": specilist,
    "disCat_id_fk": disCatIdFk,
    "doc_username": docUsername,
    "doc_password": docPassword,
    "adm_id_fk": admIdFk,
    "doc_img": docImg,
  };
}
