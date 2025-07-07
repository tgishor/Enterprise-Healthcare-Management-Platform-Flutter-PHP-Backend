// To parse this JSON data, do
//
//     final patientDiseaseDetail = patientDiseaseDetailFromJson(jsonString);

import 'package:meta/meta.dart';
import 'dart:convert';

List<PatientDiseaseDetail> patientDiseaseDetailFromJson(String str) => List<PatientDiseaseDetail>.from(json.decode(str).map((x) => PatientDiseaseDetail.fromJson(x)));

String patientDiseaseDetailToJson(List<PatientDiseaseDetail> data) => json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class PatientDiseaseDetail {
  PatientDiseaseDetail({
    required this.pId,
    required this.paHasDisId,
    required this.paHasDisRecordedDate,
    required this.pIdFk,
    required this.disIdFk,
    required this.disId,
    required this.disName,
    required this.disCatIdFk,
  });

  String pId;
  String paHasDisId;
  DateTime paHasDisRecordedDate;
  String pIdFk;
  String disIdFk;
  String disId;
  String disName;
  String disCatIdFk;

  factory PatientDiseaseDetail.fromJson(Map<String, dynamic> json) => PatientDiseaseDetail(
    pId: json["p_id"],
    paHasDisId: json["paHasDis_id"],
    paHasDisRecordedDate: DateTime.parse(json["paHasDis_recordedDate"]),
    pIdFk: json["p_id_fk"],
    disIdFk: json["dis_id_fk"],
    disId: json["dis_id"],
    disName: json["dis_name"],
    disCatIdFk: json["disCat_id_fk"],
  );

  Map<String, dynamic> toJson() => {
    "p_id": pId,
    "paHasDis_id": paHasDisId,
    "paHasDis_recordedDate": paHasDisRecordedDate.toIso8601String(),
    "p_id_fk": pIdFk,
    "dis_id_fk": disIdFk,
    "dis_id": disId,
    "dis_name": disName,
    "disCat_id_fk": disCatIdFk,
  };
}
