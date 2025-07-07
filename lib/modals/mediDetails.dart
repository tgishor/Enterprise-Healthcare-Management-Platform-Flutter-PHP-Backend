// To parse this JSON data, do
//
//     final mediDetails = mediDetailsFromJson(jsonString);

import 'package:meta/meta.dart';
import 'dart:convert';

List<MediDetails> mediDetailsFromJson(String str) => List<MediDetails>.from(json.decode(str).map((x) => MediDetails.fromJson(x)));

String mediDetailsToJson(List<MediDetails> data) => json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class MediDetails {
  MediDetails({
    required this.mediId,
    required this.mediName,
    required this.mediUsageDesc,
    required this.mediPillCode,
    required this.mediFrontImg,
    required this.mediBackImg,
    required this.dTypeIdFk,
    required this.dTypeId,
    required this.dTypeName,
  });

  String mediId;
  String mediName;
  String mediUsageDesc;
  String mediPillCode;
  String mediFrontImg;
  String mediBackImg;
  String dTypeIdFk;
  String dTypeId;
  String dTypeName;

  factory MediDetails.fromJson(Map<String, dynamic> json) => MediDetails(
    mediId: json["medi_id"],
    mediName: json["medi_name"],
    mediUsageDesc: json["medi_usageDesc"],
    mediPillCode: json["medi_pillCode"],
    mediFrontImg: json["medi_frontImg"],
    mediBackImg: json["medi_backImg"],
    dTypeIdFk: json["dType_id_fk"],
    dTypeId: json["dType_id"],
    dTypeName: json["dType_name"],
  );

  Map<String, dynamic> toJson() => {
    "medi_id": mediId,
    "medi_name": mediName,
    "medi_usageDesc": mediUsageDesc,
    "medi_pillCode": mediPillCode,
    "medi_frontImg": mediFrontImg,
    "medi_backImg": mediBackImg,
    "dType_id_fk": dTypeIdFk,
    "dType_id": dTypeId,
    "dType_name": dTypeName,
  };
}
