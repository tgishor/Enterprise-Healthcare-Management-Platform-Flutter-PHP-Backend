// To parse this JSON data, do
//
//     final medicalRecordDetailed = medicalRecordDetailedFromJson(jsonString);

import 'package:meta/meta.dart';
import 'dart:convert';

List<MedicalRecordDetailed> medicalRecordDetailedFromJson(String str) => List<MedicalRecordDetailed>.from(json.decode(str).map((x) => MedicalRecordDetailed.fromJson(x)));

String medicalRecordDetailedToJson(List<MedicalRecordDetailed> data) => json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class MedicalRecordDetailed {
  MedicalRecordDetailed({
    required this.mediRecId,
    required this.mediRecDesc,
    required this.bookId,
    required this.bookDesc,
    required this.bookDateTime,
    required this.bookAllocateDateTime,
    required this.pIdFk,
    required this.staffIdFk,
    required this.docIdFk,
    required this.hosIdFk,
    required this.bookStatusIdFk,
    required this.pId,
    required this.pName,
    required this.preId,
    required this.preDesc,
    required this.preStatusIdFk,
    required this.mediRecIdFk,
    required this.preStatusId,
    required this.preStatusName,
    required this.bookStatusId,
    required this.bookStatusName,
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

  String mediRecId;
  String mediRecDesc;
  String bookId;
  String bookDesc;
  DateTime bookDateTime;
  DateTime bookAllocateDateTime;
  String pIdFk;
  String staffIdFk;
  String docIdFk;
  String hosIdFk;
  String bookStatusIdFk;
  String pId;
  String pName;
  String preId;
  String preDesc;
  String preStatusIdFk;
  String mediRecIdFk;
  String preStatusId;
  String preStatusName;
  String bookStatusId;
  String bookStatusName;
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

  factory MedicalRecordDetailed.fromJson(Map<String, dynamic> json) => MedicalRecordDetailed(
    mediRecId: json["mediRec_id"],
    mediRecDesc: json["mediRec_desc"],
    bookId: json["book_id"],
    bookDesc: json["book_desc"],
    bookDateTime: DateTime.parse(json["book_dateTime"]),
    bookAllocateDateTime: DateTime.parse(json["book_allocateDateTime"]),
    pIdFk: json["p_id_fk"],
    staffIdFk: json["staff_id_fk"],
    docIdFk: json["doc_id_fk"],
    hosIdFk: json["hos_id_fk"],
    bookStatusIdFk: json["bookStatus_id_fk"],
    pId: json["p_id"],
    pName: json["p_name"],
    preId: json["pre_id"],
    preDesc: json["pre_desc"],
    preStatusIdFk: json["preStatus_id_fk"],
    mediRecIdFk: json["mediRec_id_fk"],
    preStatusId: json["preStatus_id"],
    preStatusName: json["preStatus_name"],
    bookStatusId: json["bookStatus_id"],
    bookStatusName: json["bookStatus_name"],
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
    "mediRec_id": mediRecId,
    "mediRec_desc": mediRecDesc,
    "book_id": bookId,
    "book_desc": bookDesc,
    "book_dateTime": bookDateTime.toIso8601String(),
    "book_allocateDateTime": bookAllocateDateTime.toIso8601String(),
    "p_id_fk": pIdFk,
    "staff_id_fk": staffIdFk,
    "doc_id_fk": docIdFk,
    "hos_id_fk": hosIdFk,
    "bookStatus_id_fk": bookStatusIdFk,
    "p_id": pId,
    "p_name": pName,
    "pre_id": preId,
    "pre_desc": preDesc,
    "preStatus_id_fk": preStatusIdFk,
    "mediRec_id_fk": mediRecIdFk,
    "preStatus_id": preStatusId,
    "preStatus_name": preStatusName,
    "bookStatus_id": bookStatusId,
    "bookStatus_name": bookStatusName,
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
