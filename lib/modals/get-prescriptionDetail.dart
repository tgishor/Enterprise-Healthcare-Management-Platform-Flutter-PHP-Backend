// To parse this JSON data, do
//
//     final prescriptionAllDetails = prescriptionAllDetailsFromJson(jsonString);

import 'package:meta/meta.dart';
import 'dart:convert';

List<PrescriptionAllDetails> prescriptionAllDetailsFromJson(String str) => List<PrescriptionAllDetails>.from(json.decode(str).map((x) => PrescriptionAllDetails.fromJson(x)));

String prescriptionAllDetailsToJson(List<PrescriptionAllDetails> data) => json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class PrescriptionAllDetails {
  PrescriptionAllDetails({
    required this.preId,
    required this.preDesc,
    required this.preStatusIdFk,
    required this.mediRecIdFk,
    required this.preStatusId,
    required this.preStatusName,
    required this.preMedId,
    required this.preMedPrecribingDate,
    required this.preMedPrecribingOverDate,
    required this.preIdFk,
    required this.medIdFk,
    required this.mediId,
    required this.mediName,
    required this.mediUsageDesc,
    required this.mediPillCode,
    required this.mediFrontImg,
    required this.mediBackImg,
    required this.dTypeIdFk,
    required this.dTypeId,
    required this.dTypeName,
    required this.doseUsageId,
    required this.preMedIdFk,
    required this.usageTimeIdFk,
    required this.medicineUsingStateIdFk,
    required this.doseQuantity,
    required this.usageTimeId,
    required this.usageTime,
    required this.usageNotiTime,
    required this.medicineUsingStateId,
    required this.medicineUsingState,
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
  });

  String preId;
  String preDesc;
  String preStatusIdFk;
  String mediRecIdFk;
  String preStatusId;
  String preStatusName;
  String preMedId;
  DateTime preMedPrecribingDate;
  DateTime preMedPrecribingOverDate;
  String preIdFk;
  String medIdFk;
  String mediId;
  String mediName;
  String mediUsageDesc;
  String mediPillCode;
  String mediFrontImg;
  String mediBackImg;
  String dTypeIdFk;
  String dTypeId;
  String dTypeName;
  String doseUsageId;
  String preMedIdFk;
  String usageTimeIdFk;
  String medicineUsingStateIdFk;
  String doseQuantity;
  String usageTimeId;
  String usageTime;
  String usageNotiTime;
  String medicineUsingStateId;
  String medicineUsingState;
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

  factory PrescriptionAllDetails.fromJson(Map<String, dynamic> json) => PrescriptionAllDetails(
    preId: json["pre_id"],
    preDesc: json["pre_desc"],
    preStatusIdFk: json["preStatus_id_fk"],
    mediRecIdFk: json["mediRec_id_fk"],
    preStatusId: json["preStatus_id"],
    preStatusName: json["preStatus_name"],
    preMedId: json["preMed_id"],
    preMedPrecribingDate: DateTime.parse(json["preMed_precribingDate"]),
    preMedPrecribingOverDate: DateTime.parse(json["preMed_precribingOverDate"]),
    preIdFk: json["pre_id_fk"],
    medIdFk: json["med_id_fk"],
    mediId: json["medi_id"],
    mediName: json["medi_name"],
    mediUsageDesc: json["medi_usageDesc"],
    mediPillCode: json["medi_pillCode"],
    mediFrontImg: json["medi_frontImg"],
    mediBackImg: json["medi_backImg"],
    dTypeIdFk: json["dType_id_fk"],
    dTypeId: json["dType_id"],
    dTypeName: json["dType_name"],
    doseUsageId: json["doseUsage_id"],
    preMedIdFk: json["preMed_id_fk"],
    usageTimeIdFk: json["usageTime_id_fk"],
    medicineUsingStateIdFk: json["medicineUsingState_id_fk"],
    doseQuantity: json["doseQuantity"],
    usageTimeId: json["usageTime_id"],
    usageTime: json["usage_Time"],
    usageNotiTime: json["usage_notiTime"],
    medicineUsingStateId: json["medicineUsingState_id"],
    medicineUsingState: json["medicineUsing_state"],
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
  );

  Map<String, dynamic> toJson() => {
    "pre_id": preId,
    "pre_desc": preDesc,
    "preStatus_id_fk": preStatusIdFk,
    "mediRec_id_fk": mediRecIdFk,
    "preStatus_id": preStatusId,
    "preStatus_name": preStatusName,
    "preMed_id": preMedId,
    "preMed_precribingDate": "${preMedPrecribingDate.year.toString().padLeft(4, '0')}-${preMedPrecribingDate.month.toString().padLeft(2, '0')}-${preMedPrecribingDate.day.toString().padLeft(2, '0')}",
    "preMed_precribingOverDate": "${preMedPrecribingOverDate.year.toString().padLeft(4, '0')}-${preMedPrecribingOverDate.month.toString().padLeft(2, '0')}-${preMedPrecribingOverDate.day.toString().padLeft(2, '0')}",
    "pre_id_fk": preIdFk,
    "med_id_fk": medIdFk,
    "medi_id": mediId,
    "medi_name": mediName,
    "medi_usageDesc": mediUsageDesc,
    "medi_pillCode": mediPillCode,
    "medi_frontImg": mediFrontImg,
    "medi_backImg": mediBackImg,
    "dType_id_fk": dTypeIdFk,
    "dType_id": dTypeId,
    "dType_name": dTypeName,
    "doseUsage_id": doseUsageId,
    "preMed_id_fk": preMedIdFk,
    "usageTime_id_fk": usageTimeIdFk,
    "medicineUsingState_id_fk": medicineUsingStateIdFk,
    "doseQuantity": doseQuantity,
    "usageTime_id": usageTimeId,
    "usage_Time": usageTime,
    "usage_notiTime": usageNotiTime,
    "medicineUsingState_id": medicineUsingStateId,
    "medicineUsing_state": medicineUsingState,
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
  };
}
