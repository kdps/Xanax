
#define countof(x) (sizeof(x)/sizeof(x[0]))

#import <Foundation/Foundation.h>
#import <UIKit/UIKit.h>
#import <WebKit/WebKit.h>
#import "SharedData.h"
#import "FLAnimatedImage.h"
#import "FLAnimatedImageView.h"
#include <ifaddrs.h>
#include <arpa/inet.h>
#import "../AppDelegate.h"
#import <AVFoundation/AVFoundation.h>
#import <QuartzCore/QuartzCore.h>

@interface Utility : NSObject
+ (FLAnimatedImageView *) getAnimatedImageFromURL: (NSString *) imageURL;
+ (FLAnimatedImageView *) getAnimatedImageFromBundle:(NSString *) bundleComponentFileName;

+(void) scheduleLocalNotification:(NSInteger) hour :(NSInteger) minutes;

+ (uint32_t) getRandomInteger :(NSInteger *) max :(NSInteger *)  min;

+ (id *) getAppDelegateObject;

+ (UIImageView *) getIntroImage:(id) selfObject: (int) width: (int) height;

+ (UIImage *) takeWebViewSnapShot:(WKWebView * __strong) webView;

+ (UIStoryboard *) getStoryBoardFromName :(NSString *) name;

+ (UIInterfaceOrientation *) getCurrentRotateState;

+ (NSLayoutConstraint *) getConstraintsFromFormat: (NSString *) format :(NSDictionary *) views;

+ (NSMutableURLRequest *) appendNeedsQueryParams:(NSString *) url :(NSString *)autoLogin;
+ (NSMutableURLRequest *) getFirstPageURL:(NSString *)autoLogin;

+ (NSURLRequest *) getReplaceURL:(NSString *) url :(NSString *)autoLogin;

+ (NSArray *) getMainBundleResourceList;
+ (NSArray *) inSpecificExtensionList : (NSArray *) list;

+ (NSString *) getIPAddress;
+ (NSString *) getMinorVersion;
+ (NSString *) getVersion;
+ (NSString *) getUUID;
+ (NSString *) generateUUID;
+ (NSString *) randomUUID;
+ (NSString *) randomNonce:(NSInteger)length;
+ (NSString *) getQueryPrefix:(NSString *) url;
+ (NSString *) getSystemVersion;
+ (NSString *) readContent :(NSString *) dirPath :(NSString *) fileName;
+ (NSString *) toJson: (NSArray *) contentDictionary;
+ (NSString *) generateDocumentPath: (NSString *) fileName;

+ (NSComparisonResult) compareVersion :(NSString *) currentVersion :(NSString *) version;

+ (NSInteger *) indexOfArray:(NSArray *) array :(NSString *) string;
+ (NSInteger) getCurrentCursorPointer:(UITextView *) textView;

+ (WKPreferences *) getWebViewPreferenceObject;

+ (WKUserScript *) getInjectionScriptObject:(NSString *) injectScript;

+ (id) getDataFromNSDefaultWithKey:(NSString *)key;

+ (BOOL) isContainsInArray:(NSArray *) array :(NSString *) string;
+ (BOOL) externalAppRequiredToOpenURL:(NSURL *)URL;
+ (BOOL) isValidNaverURLSchemes:(NSString *) url;
+ (BOOL) isVersionLessThen :(NSString *) currentVersion :(NSString *) version;
+ (BOOL) writeContent :(NSString *) content :(NSString *) dirPath :(NSString *) fileName;
+ (BOOL) isEmpty:(UITextView *) textView;

+ (void) kakaoLogin: (dispatch_block_t) success :(dispatch_block_t) failed;
+ (void) saveDataInNSDefault:(id)object key :(NSString *)key;
+ (void) AsyncThread: (dispatch_block_t) block;
+ (void) setSwitcher: (id) conditions :(id) lookup;
+ (void) delayForSeconds :(int) seconds :(dispatch_block_t) block;
+ (void) addAnchorConstraintToWebView :(WKWebView *) webView :(UIView *) view;
+ (void) configureNaverLogin:(NSString *) serviceUrlScheme :(NSString *) consumerKey :(NSString *) consumerSecret :(NSString *) appName :(id)selfObject;
+ (void) doNaverLogin:(id) selfObject;
+ (void) registerForRemoteNotifications:(UIApplication *) applicationObject :(id) selfObject;
+ (void) registerForRemoteNotificationsOnIOS10Later:(UIApplication *) applicationObject :(id) selfObject;
+ (void) rotateScreen: (UIInterfaceOrientation) newOrientation;
+ (void) setRotateByInt: (int) newOrientation;
+ (void) setClipboardContent :(NSString *) content;
+ (void) speechText :(float) rate : (NSString *) text;
+ (void) concurrentDispatchQueue : (dispatch_block_t) block :(char * _Nullable) label;
+ (void) serialDispatchQueue : (dispatch_block_t) block :(char * _Nullable) label;
+ (void) shakeView :(UIView * _Nullable) view :(CGFloat)x :(CGFloat) y;
+ (void) setRadius :(UIView * _Nullable) view :(UIRectCorner)corners;
+ (void) setFontSize:(UITextView * _Nonnull) textView : (CGFloat) fontSize;
+ (void) setAlignLeft:(UITextView * _Nonnull) textView;
+ (void) setAlignRight:(UITextView * _Nonnull) textView;
+ (void) setUnderlineStyle :(UILabel * _Nonnull) label;
+ (void) setMaximumLine :(UILabel * _Nonnull) label;
+ (void) alertWithInputBox :(NSString * _Nonnull) title :(NSString * _Nonnull) message :(UIViewController * _Nonnull) viewController :(void (^ __nullable)(void)) completion;
+ (void) bottomAlert :(NSString *_Nonnull) title :(NSString *_Nonnull) message  :(UIViewController *_Nonnull) viewController :(void (^ __nullable)(void)) completion;

@end
