import 'dart:convert';

import 'get-appointmentHistory.dart';

import 'get-loggedUserInfo.dart';
import 'get-medirecord.dart';
import 'get-medicalRecordDetailed.dart';


import 'get-patientHasDisease.dart';
import 'get-prescriptionDetail.dart';
import 'get-prescriptionHistory.dart';
import 'mediDetails.dart';

import 'package:http/http.dart' as http;


Future<List<MedicalRec>> fetchMedicalRecords(patientID) async{
  String url = 'http://10.0.2.2/finalproject/admin/mobile-app-scripts/get-mediRecord.php?id='+patientID;
  print(url);
  final response = await http.get(Uri.parse(url));
  if (response.statusCode == 400) {
    print("NO Data Found HTTP Message Nooo dataaaaaa");
    print("Message From the Server: "+jsonDecode(response.body)[0]['message']);
    return jsonDecode(response.body)[0]['message'];
  }else if(response.statusCode == 200){
    return medicalRecFromJson(response.body);
  }
  return jsonDecode(response.body)[0]['message'];
}

Future<List<AppointmentHistory>> fetchAppointmentHistory(patientID) async{
  String url = 'http://10.0.2.2/finalproject/admin/mobile-app-scripts/get-appointment-history.php?id='+patientID;
  print(url);
  final response = await http.get(Uri.parse(url));
  if (response.statusCode == 400) {
    print("NO Data Found HTTP Message Nooo dataaaaaa");
    print("Message From the Server: "+jsonDecode(response.body)[0]['message']);
    return jsonDecode(response.body)[0]['message'];
  }else if(response.statusCode == 200){
    return appointmentHistoryFromJson(response.body);
  }
  return jsonDecode(response.body)[0]['message'];
}


Future<List<MedicalRecordDetailed>> fetchMediRecordDetails(mediRecID) async{
  String url = 'http://10.0.2.2/finalproject/admin/mobile-app-scripts/get-mediRecDetail.php?id='+mediRecID;
  print(url);
  final response = await http.get(Uri.parse(url));
  if (response.statusCode == 400) {
    print("NO Data Found HTTP Message Nooo dataaaaaa");
    print("Message From the Server: "+jsonDecode(response.body)[0]['message']);
    return jsonDecode(response.body)[0]['message'];
  }else if(response.statusCode == 200){
    return medicalRecordDetailedFromJson(response.body);
  }
  return jsonDecode(response.body)[0]['message'];
}


Future<List<PrescriptionAllDetails>> fetchPrescriptionDetails(preID) async{
  String url = 'http://10.0.2.2/finalproject/admin/mobile-app-scripts/get-prescriptionDetail.php?id='+preID;
  print(url);
  final response = await http.get(Uri.parse(url));
  if (response.statusCode == 400) {
    print("NO Data Found HTTP Message Nooo dataaaaaa");
    print("Message From the Server: "+jsonDecode(response.body)[0]['message']);
    return jsonDecode(response.body)[0]['message'];
  }else if(response.statusCode == 200){
    return prescriptionAllDetailsFromJson(response.body);
  }
  return jsonDecode(response.body)[0]['message'];
}


Future<List<LoggedUserInfo>> fetchLoggedUserDetail(userID) async{
  String url = 'http://10.0.2.2/finalproject/admin/mobile-app-scripts/get-patient-info.php?id='+userID;
  print(url);
  final response = await http.get(Uri.parse(url));
  if (response.statusCode == 400) {
    print("NO Data Found HTTP Message Nooo dataaaaaa");
    print("Message From the Server: "+jsonDecode(response.body)[0]['message']);
    return jsonDecode(response.body)[0]['message'];
  }else if(response.statusCode == 200){
    return loggedUserInfoFromJson(response.body);
  }
  return jsonDecode(response.body)[0]['message'];
}

Future<List<AppointmentHistory>> fetchTodayAppointments(patientID) async{
  String url = 'http://10.0.2.2/finalproject/admin/mobile-app-scripts/get-today-appointment.php?id='+patientID;
  print(url);
  final response = await http.get(Uri.parse(url));
  if (response.statusCode == 400) {
    print("NO Data Found HTTP Message Nooo dataaaaaa");
    print("Message From the Server: "+jsonDecode(response.body)[0]['message']);
    return jsonDecode(response.body)[0]['message'];
  }else if(response.statusCode == 200){
    return appointmentHistoryFromJson(response.body);
  }
  return jsonDecode(response.body)[0]['message'];
}

Future<List<PrescriptAllHistory>> fetchPresHistoryAll(patientID,status) async{
  String url = 'http://10.0.2.2/finalproject/admin/mobile-app-scripts/get-prescriptionHistory.php?id='+patientID+'&preStatus='+status;
  print(url);
  final response = await http.get(Uri.parse(url));
  if (response.statusCode == 400) {
    print("NO Data Found HTTP Message Nooo dataaaaaa");
    print("Message From the Server: "+jsonDecode(response.body)[0]['message']);
    return jsonDecode(response.body)[0]['message'];
  }else if(response.statusCode == 200){
    return prescriptAllHistoryFromJson(response.body);
  }
  return jsonDecode(response.body)[0]['message'];
}


Future<List<PatientDiseaseDetail>> fetchPatientHasDisease(patientID,registeredDate) async{
  String url = 'http://10.0.2.2/finalproject/admin/mobile-app-scripts/get-patientBookedDiseases.php?id='+patientID+'&bookday='+registeredDate;
  print(url);
  final response = await http.get(Uri.parse(url));
  if (response.statusCode == 400) {
    print("NO Data Found HTTP Message Nooo dataaaaaa");
    print("Message From the Server: "+jsonDecode(response.body)[0]['message']);
    return jsonDecode(response.body)[0]['message'];
  }else if(response.statusCode == 200){
    return patientDiseaseDetailFromJson(response.body);
  }
  return jsonDecode(response.body)[0]['message'];
}


Future<List<MediDetails>> fetchMedicineDetail(medicineID) async{
  String url = 'http://10.0.2.2/finalproject/admin/mobile-app-scripts/get-medicineDetail.php?id='+medicineID;
  print(url);
  final response = await http.get(Uri.parse(url));
  if (response.statusCode == 400) {
    print("NO Data Found HTTP Message Nooo dataaaaaa");
    print("Message From the Server: "+jsonDecode(response.body)[0]['message']);
    return jsonDecode(response.body)[0]['message'];
  }else if(response.statusCode == 200){
    return mediDetailsFromJson(response.body);
  }
  return jsonDecode(response.body)[0]['message'];
}
