#import "Utility.h"
#import <WebKit/WebKit.h>
#import <NaverThirdPartyLogin/NaverThirdPartyLogin.h>
#import <UserNotifications/UserNotifications.h>
#import <KakaoOpenSDK/KakaoOpenSDK.h>

@import CommonCrypto;

@implementation NSArray ( ArrayWithInts )
+ (NSArray*)arrayWithInts :(const int[])ints count :(size_t)count {
    assert(count > 0 && count < 100) ;    // just in case
    
    NSNumber * numbers[count] ;
    for (int index=0; index < count; ++index) {
        numbers[index] = [NSNumber numberWithInt:ints[index]] ;
    }
    
    return [NSArray arrayWithObjects:numbers count:count];
}
@end

@implementation Utility

+(void) scheduleLocalNotification:(NSInteger) hour :(NSInteger) minutes {
    UNMutableNotificationContent* content = [[UNMutableNotificationContent alloc] init];
    content.title = [NSString localizedUserNotificationStringForKey:@"Wake up!" arguments:nil];
    content.body = [NSString localizedUserNotificationStringForKey:@"Rise and shine! It's morning time!"
            arguments:nil];
    content.sound = UNNotificationSound.defaultSound;
    //UNNotificationSound.init(named:UNNotificationSoundName(rawValue: "123.mp3"))
     
    // Configure the trigger for a 7am wakeup.
    NSDateComponents* date = [[NSDateComponents alloc] init];
    date.hour = hour;
    date.minute = minutes;
    UNCalendarNotificationTrigger* trigger = [UNCalendarNotificationTrigger
           triggerWithDateMatchingComponents:date repeats:NO];
     
    // Create the request object.
    UNNotificationRequest* request = [UNNotificationRequest
           requestWithIdentifier:@"MorningAlarm" content:content trigger:trigger];
    
    UNUserNotificationCenter* center = [UNUserNotificationCenter currentNotificationCenter];
    [center addNotificationRequest:request withCompletionHandler:^(NSError * _Nullable error) {
       if (error != nil) {
           NSLog(@"%@", error.localizedDescription);
       }
    }];
    
}

+(UIImage *) takeWebViewSnapShot:(WKWebView * __strong) _webView  {
    _webView.scrollView.showsVerticalScrollIndicator = NO;
    _webView.scrollView.showsHorizontalScrollIndicator = NO;
    
    CGPoint originalOffset = _webView.scrollView.contentOffset;
    CGFloat contentWidth = _webView.scrollView.contentSize.width;
    CGFloat contentHeight = _webView.scrollView.contentSize.height;
    CGFloat webViewHeight = _webView.frame.size.height;
    
    int imageCount = (int)(ceil(contentHeight / webViewHeight));
    
    CGFloat lastIndexOffset = imageCount == 1 ? 0 : (contentHeight - webViewHeight);
    UIImage *webViewImages[imageCount];
    
    for (int index = 0; index < imageCount ; index++) {
        if (index == imageCount - 1) {
            _webView.scrollView.contentOffset = CGPointMake(0, lastIndexOffset);
        } else {
            _webView.scrollView.contentOffset = CGPointMake(0, (index * webViewHeight));
        }
        
        UIGraphicsBeginImageContextWithOptions(CGSizeMake(contentWidth, webViewHeight), YES, UIScreen.mainScreen.scale);
        
        [_webView.layer renderInContext:UIGraphicsGetCurrentContext()];
        webViewImages[index] = UIGraphicsGetImageFromCurrentImageContext();
        UIGraphicsEndImageContext();
    }
    
    _webView.scrollView.contentOffset = originalOffset;
    
    UIGraphicsBeginImageContextWithOptions(CGSizeMake(contentWidth, contentHeight), YES, UIScreen.mainScreen.scale);
    
    for (int index = 0 ; index < imageCount ; index++) {
        if (index == imageCount -1) {
            [webViewImages[index] drawAtPoint:CGPointMake(0, lastIndexOffset)];
        } else {
            [webViewImages[index] drawAtPoint:CGPointMake(0, (index * webViewHeight))];
        }
    }
    
    UIImage *mergeImage = UIGraphicsGetImageFromCurrentImageContext();
    
    UIGraphicsEndImageContext();
    
    _webView.scrollView.showsVerticalScrollIndicator = YES;
    _webView.scrollView.showsHorizontalScrollIndicator = YES;
    
    return mergeImage;
}

/*+ (UILabel *) createUILabel {
 UILabel * label = [[UILabel alloc]initWithFrame:CGRectMake(0, 0, 320, 480)];
 
 return label;
 }*/

+ (void) bottomAlert :(NSString *) title :(NSString *) message  :(UIViewController *) viewController :(void (^ __nullable)(void)) completion {
    UIAlertController *alertController = [UIAlertController alertControllerWithTitle:title message:message preferredStyle:UIAlertControllerStyleActionSheet];
    UIAlertAction *cancelAction = [UIAlertAction actionWithTitle:@"Cancel" style:UIAlertActionStyleCancel handler:^(UIAlertAction * action) {
        //action when pressed button
    }];
    
    UIAlertAction * okAction = [UIAlertAction actionWithTitle:@"Okay" style:UIAlertActionStyleDefault handler:^(UIAlertAction * action) {
        //action when pressed button
    }];
    
    [alertController addAction:cancelAction];
    [alertController addAction:okAction];
    
    [viewController presentViewController:alertController animated: YES completion: completion];
}

+ (void) alertWithInputBox :(NSString *) title :(NSString *) message :(UIViewController *) viewController :(void (^ __nullable)(void)) completion :(NSString *) placeholder {
    UIAlertController * alertController = [UIAlertController alertControllerWithTitle: title
                                                                              message: message
                                                                       preferredStyle:UIAlertControllerStyleAlert];
    
    [alertController addTextFieldWithConfigurationHandler:^(UITextField *textField) {
        textField.placeholder = placeholder;
        textField.textColor = [UIColor blueColor];
        textField.clearButtonMode = UITextFieldViewModeWhileEditing;
        textField.borderStyle = UITextBorderStyleRoundedRect;
    }];
    
    [alertController addAction:[UIAlertAction actionWithTitle:@"OK" style:UIAlertActionStyleDefault handler:^(UIAlertAction *action) {
        NSArray * textfields = alertController.textFields;
        UITextField * namefield = textfields[0];
        UITextField * passwordfiled = textfields[1];
        NSLog(@"%@:%@",namefield.text,passwordfiled.text);
    }]];
    
    [viewController presentViewController:alertController animated:YES completion:completion];
}

+ (void) setMaximumLine :(UILabel *) label {
    label.numberOfLines = 2;
}

+ (void) setShadow :(UILabel *) label {
    label.layer.shadowOffset = CGSizeMake(3, 3);
    label.layer.shadowOpacity = 0.7;
    label.layer.shadowRadius = 2;
}

+ (void) setUnderlineStyle :(UILabel *) label {
    label.backgroundColor=[UIColor lightGrayColor];
    NSMutableAttributedString *attributedString;
    attributedString = [[NSMutableAttributedString alloc] initWithString:@"Apply Underlining"];
    [attributedString addAttribute:NSUnderlineStyleAttributeName value:@1 range:NSMakeRange(0, [attributedString length])];
    [label setAttributedText:attributedString];
}

+ (UIStoryboard *) getStoryBoardFromName :(NSString *) name {
    UIStoryboard * storyBoard = [UIStoryboard storyboardWithName:name bundle:[NSBundle mainBundle]];
    return storyBoard;
}

+ (BOOL) isEmpty:(UITextView *) textView {
    return textView.text.length == 0;
}

+ (NSInteger) getCurrentCursorPointer:(UITextView *) textView {
    NSInteger pos = [textView offsetFromPosition:textView.beginningOfDocument
                                      toPosition:textView.selectedTextRange.start];
    
    return pos;
}

+ (void) setAlignLeft:(UITextView *) textView {
    textView.textAlignment = NSTextAlignmentLeft;
}

+ (void) setAlignRight:(UITextView *) textView {
    textView.textAlignment = NSTextAlignmentRight;
}

+ (void) setFontSize:(UITextView *) textView : (CGFloat) fontSize {
    textView.font = [UIFont systemFontOfSize:fontSize];
}

+(FLAnimatedImageView *) getAnimatedImageFromURL: (NSString *) imageURL {
    NSData *bundleData = [NSData dataWithContentsOfURL:[NSURL URLWithString:imageURL]];
    
    FLAnimatedImage *image = [FLAnimatedImage animatedImageWithGIFData:bundleData];
    FLAnimatedImageView *imageView = [[FLAnimatedImageView alloc] init];
    imageView.animatedImage = image;
    
    return imageView;
}

+(UIImage *) getImageFromBundle:(NSString *) bundleComponentFileName {
    UIImageView* imageView = [[UIImageView alloc] initWithFrame:CGRectMake(50, 100, 16, 16)];
    UIImage *image = [UIImage imageWithContentsOfFile: [[NSBundle mainBundle] pathForResource:@"Images/Wall1" ofType:@"png"]];
    
    return image;
}

+(FLAnimatedImageView *) getAnimatedImageFromBundle:(NSString *) bundleComponentFileName {
    NSString *bundleFilePath = [[[NSBundle mainBundle] resourcePath] stringByAppendingPathComponent:bundleComponentFileName];
    NSData *bundleData = [NSData dataWithContentsOfFile:bundleFilePath];
    
    FLAnimatedImage *image = [FLAnimatedImage animatedImageWithGIFData:bundleData];
    FLAnimatedImageView *imageView = [[FLAnimatedImageView alloc] init];
    imageView.animatedImage = image;
    
    return imageView;
}

+ (void) delayForSeconds :(int) seconds :(dispatch_block_t) block {
    dispatch_after(dispatch_time(DISPATCH_TIME_NOW, seconds * NSEC_PER_SEC), dispatch_get_main_queue(), block);
}

+(void) setSwitcher: (id) conditions :(id) lookup {
    ((void (^)(void))conditions[lookup] ?: ^{
        NSLog(@"default");
    })();
}

+(void)saveDataInNSDefault:(id)object key:(NSString *)key {
    /*if (@available(iOS 11.0, *)) {
     NSData *encodedObject = [NSKeyedArchiver archivedDataWithRootObject:object];
     NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
     [defaults setObject:encodedObject forKey:key];
     [defaults synchronize];
     } else {*/
    NSError *error;
    NSData *encodedObject = [NSKeyedArchiver archivedDataWithRootObject:object requiringSecureCoding:false error:&error];
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    [defaults setObject:encodedObject forKey:key];
    [defaults synchronize];
    //}
}

+ (id)getDataFromNSDefaultWithKey:(NSString *)key{
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    NSData *encodedObject = [defaults objectForKey:key];
    id object = [NSKeyedUnarchiver unarchiveObjectWithData:encodedObject];
    return object;
}

+ (NSMutableURLRequest *) appendNeedsQueryParams:(NSString *) url :(NSString *)autoLogin {
    NSURL *temp = [NSURL URLWithString:[NSString stringWithFormat:@"%@&google_token=%@&device_token=%@&device_type=I&autoLogin=%@&version=%@", url, [SharedData LoadFromUserDefaults:@"TOKEN"], [self getUUID], autoLogin, [self getVersion]]];
    NSURLComponents *components = [NSURLComponents componentsWithURL:temp resolvingAgainstBaseURL:NO];
    NSMutableURLRequest *mutableRequest = [NSMutableURLRequest requestWithURL:components.URL];
    
    return mutableRequest;
}

+ (NSURLRequest *) getReplaceURL:(NSString *) url :(NSString *)autoLogin {
    NSURLRequest *request = [[NSURLRequest alloc] initWithURL:[NSURL URLWithString:[NSString stringWithFormat:@"%@%@google_token=%@&device_token=%@&device_type=I&autoLogin=%@&version=%@", url, [Utility getQueryPrefix:url], [SharedData LoadFromUserDefaults:@"TOKEN"], [Utility getUUID], autoLogin, [self getVersion]]]];
    
    return request;
}

// Get prefix from url query
+ (NSString *) getQueryPrefix:(NSString *) url {
    NSString * prefix = @"";
    if([url rangeOfString:@"?"].length > 0) {
        prefix = @"&";
    } else {
        prefix = @"?";
    }
    
    return prefix;
}

+ (NSString *) generateDocumentPath: (NSString *) fileName {
    NSArray *paths = NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES);
    NSString *documentsDirectory = [paths objectAtIndex:0];
    NSString *filePath =  [documentsDirectory stringByAppendingPathComponent:fileName];
    
    return filePath;
}


+ (NSString *) toJson: (NSArray *) contentDictionary {
    NSError *error;
    NSData *jsonData = [NSJSONSerialization dataWithJSONObject:contentDictionary options:NSJSONWritingPrettyPrinted error:&error];
    NSString *jsonString;
    if (jsonData) {
        jsonString = [[NSString alloc] initWithData:jsonData encoding:NSUTF8StringEncoding];
    } else {
        NSLog(@"Got an error: %@", error);
        jsonString = @"";
    }

    return jsonString;
}

+ (NSMutableURLRequest *) getFirstPageURL:(NSString *)autoLogin {
    NSString *urlData = [NSString stringWithFormat:
                         @"%@/index.php?google_token=%@&device_token=%@&device_type=I&autoLogin=%@&version=%@",
                         [SharedData getInstance].HostURL,
                         [SharedData LoadFromUserDefaults:@"TOKEN"],
                         [self getUUID],
                         autoLogin,
                         [self getVersion]
                         ];
    
    NSURL *url = [NSURL URLWithString:urlData];
    NSURLComponents *components = [NSURLComponents componentsWithURL:url
                                             resolvingAgainstBaseURL:NO];
    //components.query = params;
    
    NSMutableURLRequest *mutableRequest = [NSMutableURLRequest requestWithURL:components.URL];
    
    return mutableRequest;
}

+ (NSString*) getUUID {
    NSUserDefaults* userDefault = [NSUserDefaults standardUserDefaults];
    NSString* iOSUUID = [userDefault stringForKey:@"UUID_KEY"];
    
    if(iOSUUID == nil || [iOSUUID isEqual:@""]) {
        iOSUUID = [[NSUUID UUID] UUIDString];
    }
    
    [userDefault setObject:iOSUUID
                    forKey:@"UUID_KEY"];
    [userDefault synchronize];
    
    return [NSString stringWithCString:[iOSUUID UTF8String]
                              encoding:NSUTF8StringEncoding];
}

+(NSString*) generateUUID {
    CFUUIDRef newUniqueID = CFUUIDCreate(kCFAllocatorDefault);
    CFStringRef newUniqueIDString = CFUUIDCreateString(kCFAllocatorDefault, newUniqueID);
    NSString *guid = (__bridge NSString *)newUniqueIDString;
    CFRelease(newUniqueIDString);
    CFRelease(newUniqueID);
    return([guid lowercaseString]);
}

+ (NSString *)randomUUID {
    if(NSClassFromString(@"NSUUID")) { // only available in iOS >= 6.0
        return [[NSUUID UUID] UUIDString];
    }
    CFUUIDRef uuidRef = CFUUIDCreate(kCFAllocatorDefault);
    CFStringRef cfuuid = CFUUIDCreateString(kCFAllocatorDefault, uuidRef);
    CFRelease(uuidRef);
    NSString *uuid = [((__bridge NSString *) cfuuid) copy];
    CFRelease(cfuuid);
    return uuid;
}

+(WKPreferences* )getWebViewPreferenceObject {
    return [[WKPreferences alloc] init];
}

+ (NSString *)randomNonce:(NSInteger)length {
    NSAssert(length > 0, @"Expected nonce to have positive length");
    NSString *characterSet = @"0123456789ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvwxyz-._";
    NSMutableString *result = [NSMutableString string];
    NSInteger remainingLength = length;
    
    while (remainingLength > 0) {
        NSMutableArray *randoms = [NSMutableArray arrayWithCapacity:16];
        for (NSInteger i = 0; i < 16; i++) {
            uint8_t random = 0;
            int errorCode = SecRandomCopyBytes(kSecRandomDefault, 1, &random);
            NSAssert(errorCode == errSecSuccess, @"Unable to generate nonce: OSStatus %i", errorCode);
            
            [randoms addObject:@(random)];
        }
        
        for (NSNumber *random in randoms) {
            if (remainingLength == 0) {
                break;
            }
            
            if (random.unsignedIntValue < characterSet.length) {
                unichar character = [characterSet characterAtIndex:random.unsignedIntValue];
                [result appendFormat:@"%C", character];
                remainingLength--;
            }
        }
    }
    
    return result;
}

+(void) registerForRemoteNotificationsOnIOS10Later:(UIApplication *) applicationObject :(id) selfObject {
    // iOS 10 or later
    // For iOS 10 display notification (sent via APNS)
    UNAuthorizationOptions authOptions = UNAuthorizationOptionAlert | UNAuthorizationOptionSound | UNAuthorizationOptionBadge;
    [[UNUserNotificationCenter currentNotificationCenter] requestAuthorizationWithOptions:authOptions
                                                                        completionHandler:^(BOOL granted, NSError * _Nullable error) { }];
    [UNUserNotificationCenter currentNotificationCenter].delegate = selfObject;
    [applicationObject registerForRemoteNotifications];
}

+(void) registerForRemoteNotifications:(UIApplication *) applicationObject :(id) selfObject {
    if ([UNUserNotificationCenter class] != nil) {
        // iOS 10 or later
        // For iOS 10 display notification (sent via APNS)
        [UNUserNotificationCenter currentNotificationCenter].delegate = selfObject;
        UNAuthorizationOptions authOptions = UNAuthorizationOptionAlert | UNAuthorizationOptionSound | UNAuthorizationOptionBadge;
        [[UNUserNotificationCenter currentNotificationCenter]
         requestAuthorizationWithOptions:authOptions
         completionHandler:^(BOOL granted, NSError * _Nullable error) {
            // ...
        }];
    } else {
        // iOS 10 notifications aren't available; fall back to iOS 8-9 notifications.
        UIUserNotificationType allNotificationTypes =
        (UIUserNotificationTypeSound | UIUserNotificationTypeAlert | UIUserNotificationTypeBadge);
        UIUserNotificationSettings *settings =
        [UIUserNotificationSettings settingsForTypes:allNotificationTypes categories:nil];
        [applicationObject registerUserNotificationSettings:settings];
    }
    
    [applicationObject registerForRemoteNotifications];
}

+ (NSString *)getMinorVersion {
    NSDictionary *infoDictionary = [[NSBundle mainBundle] infoDictionary];
    NSString *minorVersion = [infoDictionary objectForKey:@"CFBundleVersion"];
    
    return [NSString stringWithFormat:@"%@",minorVersion];
}

+ (NSString *)getVersion {
    NSDictionary *infoDictionary = [[NSBundle mainBundle] infoDictionary];
    NSString *majorVersion = [infoDictionary objectForKey:@"CFBundleShortVersionString"];
    
    return [NSString stringWithFormat:@"%@",majorVersion];
}

+(void) addAnchorConstraintToWebView :(WKWebView *) webView :(UIView *) view {
    NSMutableArray <NSLayoutConstraint*> *arrConst = [NSMutableArray <NSLayoutConstraint*> new];
    
    NSLayoutConstraint *topCons = [webView.topAnchor constraintEqualToAnchor:view.topAnchor];
    NSLayoutConstraint *trailCons = [webView.trailingAnchor constraintEqualToAnchor:view.trailingAnchor];
    NSLayoutConstraint *leadCons = [webView.leadingAnchor constraintEqualToAnchor:view.leadingAnchor];
    NSLayoutConstraint *bottomCons = [webView.bottomAnchor constraintEqualToAnchor:view.bottomAnchor];
    
    [arrConst addObject:topCons];
    [arrConst addObject:trailCons];
    [arrConst addObject:leadCons];
    [arrConst addObject:bottomCons];
    
    [NSLayoutConstraint activateConstraints:arrConst];
}

+(NSInteger *) indexOfArray:(NSArray *) array :(NSString *) string {
    BOOL isContains = false;
    NSInteger * index = 0;
    for (id object in array) {
        if ([string containsString:object]) {
            isContains = true;
            break;
        }
        ++index;
    }
    
    return index;
}

+ (NSString *)getIPAddress {
    NSString *address = @"error";
    struct ifaddrs *interfaces = NULL;
    struct ifaddrs *temp_addr = NULL;
    int success = 0;
    // retrieve the current interfaces - returns 0 on success
    success = getifaddrs(&interfaces);
    if (success == 0) {
        // Loop through linked list of interfaces
        temp_addr = interfaces;
        while(temp_addr != NULL) {
            if(temp_addr->ifa_addr->sa_family == AF_INET) {
                // Check if interface is en0 which is the wifi connection on the iPhone
                if([[NSString stringWithUTF8String:temp_addr->ifa_name] isEqualToString:@"en0"]) {
                    // Get NSString from C String
                    address = [NSString stringWithUTF8String:inet_ntoa(((struct sockaddr_in *)temp_addr->ifa_addr)->sin_addr)];
                    
                }
                
            }
            
            temp_addr = temp_addr->ifa_next;
        }
    }
    // Free memory
    freeifaddrs(interfaces);
    return address;
}

+ (void) speechText :(float) rate : (NSString *) text {
    AVSpeechSynthesizer *synthesizer = [[AVSpeechSynthesizer alloc]init];
    AVSpeechUtterance *utterance = [AVSpeechUtterance speechUtteranceWithString:text];
    [utterance setRate:0.2f];
    [synthesizer speakUtterance:utterance];
}

+ (BOOL) isVersionLessThen :(NSString *) currentVersion :(NSString *) version {
    NSComparisonResult result = [self compareVersion:currentVersion :version];
    
    return result = NSOrderedAscending;
}

+ (NSComparisonResult) compareVersion :(NSString *) currentVersion :(NSString *) version {
    NSComparisonResult result = [currentVersion compare:version options:NSNumericSearch];
    return result;
}

+ (NSString *) getSystemVersion {
    NSString *version = [[UIDevice currentDevice] systemVersion];
    return version;
}

+ (void) setClipboardContent :(NSString *) content {
    [[UIPasteboard generalPasteboard] setString:content];
}

+ (NSArray *) inSpecificExtensionList : (NSArray *) list {
    NSArray * lists = [list filteredArrayUsingPredicate:[NSPredicate predicateWithFormat:@"SELF ENDSWITH '.jpg'"]];
    return lists;
}

+ (NSArray *) getMainBundleResourceList {
    NSString *path = [[NSBundle mainBundle] bundlePath];
    NSArray *list = [[NSFileManager defaultManager] contentsOfDirectoryAtPath:path error:nil];
    
    return list;
}

+ (UIInterfaceOrientation *) getCurrentRotateState {
    return (UIDeviceOrientation)[UIDevice currentDevice].orientation;
}

+ (NSString *) readContent :(NSString *) dirPath :(NSString *) fileName {
    NSString * filePath = [dirPath stringByAppendingPathComponent:fileName];
    
    __autoreleasing NSError *error;
    NSString * readContents = [NSString stringWithContentsOfFile:filePath encoding:NSUTF8StringEncoding error:&error];
    
    return readContents;
}

+ (BOOL) writeContent :(NSString *) content :(NSString *) dirPath :(NSString *) fileName {
    NSString *filePath = [dirPath stringByAppendingPathComponent:fileName];
    
    __autoreleasing NSError *error;
    BOOL ret = [content writeToFile:filePath atomically:YES encoding:NSUTF8StringEncoding error:&error];
    
    return ret;
}

+ (uint32_t) getRandomInteger :(NSInteger *) max :(NSInteger *)  min {
    uint32_t randomIntegerWithinRange = arc4random_uniform(max) + min;
    
    return randomIntegerWithinRange;
}

+ (id) getAppDelegateObject {
    id < UIApplicationDelegate> shared = [UIApplication sharedApplication].delegate;
    
    if ([shared isKindOfClass:[AppDelegate class]]) {
        shared = (AppDelegate *) shared;
    }
    
    return shared;
}

+ (void) setRotateByInt: (int) newOrientation {
    NSNumber *value = [NSNumber numberWithInt:newOrientation];
    [[UIDevice currentDevice] setValue:value forKey:@"orientation"];
}

+ (void) rotateScreen: (UIInterfaceOrientation) newOrientation {
    NSString* orientation = @"orientation";
    
    UIInterfaceOrientation deviceOrientation = (UIInterfaceOrientation) [UIDevice currentDevice].orientation;
    
    UIDevice* currentDevice = [UIDevice currentDevice];
    [currentDevice setValue:@(UIInterfaceOrientationUnknown) forKey:orientation];
    [currentDevice setValue:@(newOrientation) forKey:orientation];
    // restore device orientation
    [currentDevice setValue:@(deviceOrientation) forKey:orientation];
    [UIViewController attemptRotationToDeviceOrientation];
}

+ (void) kakaoLogin: (dispatch_block_t) success :(dispatch_block_t) failed {
    KOSession *session = [KOSession sharedSession];
    
    if ([session isOpen]) {
        [session close];
    }
    
    const int numbers[] = {KOAuthTypeTalk, KOAuthTypeAccount};
    NSArray * array = [NSArray arrayWithInts:numbers count:countof(numbers)];
    
    [session openWithCompletionHandler:^(NSError *error) {
        if ([session isOpen]) {
            dispatch_async(dispatch_get_main_queue(), success);
        } else {
            dispatch_async(dispatch_get_main_queue(), failed);
        }
    } authTypes:array];
}

+ (void) shakeView :(UIView *) view :(CGFloat)x :(CGFloat) y {
    CABasicAnimation *shake = [CABasicAnimation animationWithKeyPath:@"position"];
    [shake setDuration:0.1];
    [shake setRepeatCount:2];
    [shake setAutoreverses:YES];
    [shake setFromValue:[NSValue valueWithCGPoint:
                         CGPointMake(x, y)]];
    [shake setToValue:[NSValue valueWithCGPoint:
                       CGPointMake(x, y)]];
    [view.layer addAnimation:shake forKey:@"position"];
}

+ (void) serialDispatchQueue : (dispatch_block_t) block :(char * _Nullable) label {
    dispatch_async(dispatch_queue_create(label, NULL), block);
}

+ (void) concurrentDispatchQueue : (dispatch_block_t) block :(char * _Nullable) label {
    dispatch_async(dispatch_queue_create(label, DISPATCH_QUEUE_CONCURRENT), block);
}

+ (void) AsyncThread: (dispatch_block_t) block {
    dispatch_async(dispatch_get_main_queue(), block);
}

+(BOOL) isContainsInArray:(NSArray *) array :(NSString *) string {
    BOOL isContains = false;
    for (id object in array) {
        if ([string containsString:object]) {
            isContains = true;
            break;
        }
    }
    
    return isContains;
}

+(void) doNaverLogin:(id) selfObject {
    [NaverThirdPartyLoginConnection getSharedInstance].delegate = selfObject;
    [[NaverThirdPartyLoginConnection getSharedInstance] resetToken];
    [[NaverThirdPartyLoginConnection getSharedInstance] requestThirdPartyLogin];
}

+(NSLayoutConstraint *) getConstraintsFromFormat: (NSString *) format :(NSDictionary *) views {
    return [NSLayoutConstraint constraintsWithVisualFormat:format
                                                   options:0
                                                   metrics:nil
                                                     views:views];
}

/*
 
 NSDictionary *views = NSDictionaryOfVariableBindings(self.wkWebView);
 [self.view addConstraints:[NSLayoutConstraint constraintsWithVisualFormat:@"H:|-0-[webView(>=0)]-0-|"
 options:0
 metrics:nil
 views:views]];
 
 [self.view addConstraints:[NSLayoutConstraint constraintsWithVisualFormat:@"V:|-0-[webView(>=0)]-0-|"
 options:0
 metrics:nil
 views:views]];
 
 **/

+ (BOOL)externalAppRequiredToOpenURL:(NSURL *)URL {
    NSSet *validSchemes = [NSSet setWithArray:@[@"http", @"https", @"tel"]];
    return ![validSchemes containsObject:URL.scheme];
}

+(BOOL) isValidNaverURLSchemes:(NSString *) url {
    NSString *someRegexp = @"[a-zA_Z_]+";
    NSPredicate *myTest = [NSPredicate predicateWithFormat:@"SELF MATCHES %@", someRegexp];
    
    return [myTest evaluateWithObject: url];
}

+(void) setRadius :(UIView *) view :(UIRectCorner)corners {
    UIBezierPath *rounded = [UIBezierPath bezierPathWithRoundedRect:view.bounds
                                                  byRoundingCorners:corners
                                                        cornerRadii:CGSizeMake(20.0, 20.0)];
    
    CAShapeLayer *shape = [[CAShapeLayer alloc] init];
    [shape setPath:rounded.CGPath];
    view.layer.mask = shape;
}

+(UIImageView *) getIntroImage:(id) selfObject: (int) width: (int) height {
    UIImageView * imageView = [[UIImageView alloc] initWithFrame:CGRectMake(10, 10, 300, 400)];
    [imageView setImage:[UIImage imageNamed:@"intro.jpg"]];
    [imageView setContentMode:UIViewContentModeScaleToFill];
    
    imageView.frame = CGRectMake(0, 0, width, height);
    imageView.contentMode = UIViewContentModeScaleToFill;
    imageView.clipsToBounds = true;
    
    return imageView;
}

+(void)configureNaverLogin:(NSString *) serviceUrlScheme :(NSString *) consumerKey :(NSString *) consumerSecret :(NSString *) appName : (id) selfObject {
    if(![self isValidNaverURLSchemes:serviceUrlScheme]) {
        @throw [NSException exceptionWithName: @"URLScheme is not valid"
                                       reason: @"URLScheme is not valid"
                                     userInfo: nil];
    }
    
    NaverThirdPartyLoginConnection *thirdConn = [NaverThirdPartyLoginConnection getSharedInstance];
    thirdConn.delegate = selfObject;
    [thirdConn setIsNaverAppOauthEnable: YES]; // 네이버 앱 사용 안할 때는 NO
    [thirdConn setIsInAppOauthEnable: YES]; // 내장 웹뷰 사용 안할 때는 NO
    [thirdConn setOnlyPortraitSupportInIphone: YES]; // 포트레이트 레이아웃만 사용하는 경우.
    [thirdConn setServiceUrlScheme: serviceUrlScheme];
    [thirdConn setConsumerKey: consumerKey];
    [thirdConn setConsumerSecret: consumerSecret];
    [thirdConn setAppName: appName];
}

+(WKUserScript *)getInjectionScriptObject:(NSString *) injectScript {
    NSString *script = injectScript;
    
    return [[WKUserScript alloc] initWithSource: script
                                  injectionTime: WKUserScriptInjectionTimeAtDocumentStart
                               forMainFrameOnly: YES];
}
@end
