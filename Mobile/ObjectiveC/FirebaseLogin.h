#import <Foundation/Foundation.h>
#import <UIKit/UIKit.h>
#import <WebKit/WebKit.h>
#import <AuthenticationServices/ASAuthorizationAppleIDProvider.h>
#import <AuthenticationServices/ASAuthorizationController.h>

@interface FirebaseLogin : NSObject {
    NSString *currentNonce;
}

    + (void) appleLogin:(id)selfObject;
    + (void)startSignInWithAppleFlow:(id) selfObject API_AVAILABLE(ios(13.0));
    + (NSString *)stringBySha256HashingString:(NSString *)input;
    + (NSString *)randomNonce:(NSInteger)length;
    + (NSString *) getCurrentNonce;

@property (nonatomic) NSString* currentNonce;

@end
