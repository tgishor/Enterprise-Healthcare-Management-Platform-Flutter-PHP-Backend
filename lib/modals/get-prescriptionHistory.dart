// To parse this JSON data, do
//
//     final prescriptAllHistory = prescriptAllHistoryFromJson(jsonString);

import 'package:meta/meta.dart';
import 'dart:convert';

List<PrescriptAllHistory> prescriptAllHistoryFromJson(String str) => List<PrescriptAllHistory>.from(json.decode(str).map((x) => PrescriptAllHistory.fromJson(x)));

String prescriptAllHistoryToJson(List<PrescriptAllHistory> data) => json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class PrescriptAllHistory {
  PrescriptAllHistory({
    required this.preId,
    required this.preDesc,
    required this.preStatusIdFk,
    required this.mediRecIdFk,
    required this.preStatusId,
    required this.preStatusName,
    required this.mediRecId,
    required this.mediRecDesc,
    required this.bookIdFk,
    required this.mediRecDate,
    required this.bookId,
    required this.bookDesc,
    required this.bookDateTime,
    required this.bookAllocateDateTime,
    required this.pIdFk,
    required this.staffIdFk,
    required this.docIdFk,
    required this.hosIdFk,
    required this.bookStatusIdFk,
    required this.docName,
    required this.docId,
    required this.pId,
  });

  String preId;
  String preDesc;
  String preStatusIdFk;
  String mediRecIdFk;
  String preStatusId;
  String preStatusName;
  String mediRecId;
  String mediRecDesc;
  String bookIdFk;
  DateTime mediRecDate;
  String bookId;
  String bookDesc;
  DateTime bookDateTime;
  DateTime bookAllocateDateTime;
  String pIdFk;
  String staffIdFk;
  String docIdFk;
  String hosIdFk;
  String bookStatusIdFk;
  String docName;
  String docId;
  String pId;

  factory PrescriptAllHistory.fromJson(Map<String, dynamic> json) => PrescriptAllHistory(
    preId: json["pre_id"],
    preDesc: json["pre_desc"],
    preStatusIdFk: json["preStatus_id_fk"],
    mediRecIdFk: json["mediRec_id_fk"],
    preStatusId: json["preStatus_id"],
    preStatusName: json["preStatus_name"],
    mediRecId: json["mediRec_id"],
    mediRecDesc: json["mediRec_desc"],
    bookIdFk: json["book_id_fk"],
    mediRecDate: DateTime.parse(json["mediRec_date"]),
    bookId: json["book_id"],
    bookDesc: json["book_desc"],
    bookDateTime: DateTime.parse(json["book_dateTime"]),
    bookAllocateDateTime: DateTime.parse(json["book_allocateDateTime"]),
    pIdFk: json["p_id_fk"],
    staffIdFk: json["staff_id_fk"],
    docIdFk: json["doc_id_fk"],
    hosIdFk: json["hos_id_fk"],
    bookStatusIdFk: json["bookStatus_id_fk"],
    docName: json["doc_name"],
    docId: json["doc_id"],
    pId: json["p_id"],
  );

  Map<String, dynamic> toJson() => {
    "pre_id": preId,
    "pre_desc": preDesc,
    "preStatus_id_fk": preStatusIdFk,
    "mediRec_id_fk": mediRecIdFk,
    "preStatus_id": preStatusId,
    "preStatus_name": preStatusName,
    "mediRec_id": mediRecId,
    "mediRec_desc": mediRecDesc,
    "book_id_fk": bookIdFk,
    "mediRec_date": mediRecDate.toIso8601String(),
    "book_id": bookId,
    "book_desc": bookDesc,
    "book_dateTime": bookDateTime.toIso8601String(),
    "book_allocateDateTime": bookAllocateDateTime.toIso8601String(),
    "p_id_fk": pIdFk,
    "staff_id_fk": staffIdFk,
    "doc_id_fk": docIdFk,
    "hos_id_fk": hosIdFk,
    "bookStatus_id_fk": bookStatusIdFk,
    "doc_name": docName,
    "doc_id": docId,
    "p_id": pId,
  };
}
