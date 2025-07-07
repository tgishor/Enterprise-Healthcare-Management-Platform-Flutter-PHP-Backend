import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:introduction_screen/introduction_screen.dart';
import 'package:smart_hrms_app/Screens/userNameLogin.dart';
import '../constants.dart';

class IntroductionScreens extends StatelessWidget {
  const IntroductionScreens({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      child: IntroductionScreen(
          pages: [
            PageViewModel(
              image: Container(child: Image.asset("images/logo.png",width: 230,)),
              title: 'Find Your Doctor',
              bodyWidget: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  buildImage("images/intro-slides/image-1.png"),
                ],
              ),
              //getPageDecoration, a method to customise the page style
              decoration: getPageDecoration(),
              reverse: false
            ),
            PageViewModel(
                image: Container(child: Image.asset("images/logo.png",width: 230,)),
                title: 'View Your Medical Records',
                bodyWidget: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    buildImage("images/intro-slides/image-2.png"),
                  ],
                ),
                //getPageDecoration, a method to customise the page style
                decoration: getPageDecoration(),
                reverse: false
            ),
            PageViewModel(
                image: Container(child: Image.asset("images/logo.png",width: 200,)),
                title: 'Get Prescription Updates',
                bodyWidget: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    buildImage("images/intro-slides/image-3.png"),
                  ],
                ),
                //getPageDecoration, a method to customise the page style
                decoration: getPageDecoration(),
                reverse: false
            ),
          ],
          onDone: () {
            Navigator.push(
              context,
              MaterialPageRoute(
                  builder: (context) => applicationNew()
              ),
            );
          },
          //ClampingScrollPhysics prevent the scroll offset from exceeding the bounds of the content.
          scrollPhysics: const ClampingScrollPhysics(),
          showDoneButton: true,
          showNextButton: true,
          showSkipButton: true,
          isBottomSafeArea: true,
          skip:
          const Text("Skip", style: TextStyle(fontWeight: FontWeight.w600)),
          next: const Icon(Icons.forward),
          done:
          const Text("Done", style: TextStyle(fontWeight: FontWeight.w600)),
          dotsDecorator: getDotsDecorator()),
    );
  }

  //widget to add the image on screen
  Widget buildImage(String imagePath) {
    return Container(
        child: Image.asset(
          imagePath,
          width: 450,
          height: 450,
        ));
  }

  //method to customise the page style
  PageDecoration getPageDecoration() {
    return const PageDecoration(
      titleTextStyle: TextStyle(
        color: appThemeColor,
        fontSize: 20,
        fontWeight: FontWeight.bold
      ),
      imagePadding: EdgeInsets.only(top: 0),
      imageFlex: 1,
      bodyFlex: 3,
      pageColor: appBgDefault,
      bodyPadding: EdgeInsets.only(top: 8, left: 20, right: 20),
      titlePadding: EdgeInsets.only(top: 2),
      bodyTextStyle: TextStyle(color: Colors.black54, fontSize: 15),
    );
  }

  //method to customize the dots style
  DotsDecorator getDotsDecorator() {
    return const DotsDecorator(
      spacing: EdgeInsets.symmetric(horizontal: 2),
      activeColor: Colors.indigo,
      color: appBgDefault,
      activeSize: Size(12, 5),
      activeShape: RoundedRectangleBorder(
        borderRadius: BorderRadius.all(Radius.circular(25.0)),
      ),
    );
  }
}