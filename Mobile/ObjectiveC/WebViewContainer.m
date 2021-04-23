#import "WebViewContainer.h"
#import <WebKit/WebKit.h>
// #import <NaverThirdPartyLogin/NaverThirdPartyLogin.h>
#import <UserNotifications/UserNotifications.h>

@import CommonCrypto;
@implementation WebViewContainer

static NSString * LOG_TAG = @"WEBVIEW_LOG";

#pragma mark - Action Methods
- (IBAction)back:(id) sender :(WKWebView *) webView {
    if ([webView canGoBack]) {
        [webView goBack];
    }
}

- (IBAction)forword:(id) sender :(WKWebView *) webView {
    if ([webView canGoForward]) {
        [webView goForward];
    }
}

- (IBAction)refresh:(id) sender :(WKWebView *) webView {
    [webView reload];
}

- (IBAction)jsTrigger:(id) sender :(WKWebView *) webView {
    //[self triggerJS:@"window.webkit.messageHandlers.callbackHandler.postMessage('Hello Native!');" webView:webView];
}

+(WKWebViewConfiguration*) webConfig :(WKPreferences *) _webPreference :(WKProcessPool *) _webProcessPool :(WKWebViewConfiguration *) _webConfig :(id) selfObject :(NSString *) javascriptNamespace {
    if (!_webPreference) {
        _webPreference = [[WKPreferences alloc] init];
        _webPreference.javaScriptEnabled = YES;
        _webPreference.javaScriptCanOpenWindowsAutomatically = YES;
    }
    
    if (!_webProcessPool) {
        _webProcessPool= [[WKProcessPool alloc] init];
    }
    
    if (!_webConfig) {
        _webConfig = [[WKWebViewConfiguration alloc] init];
        
        // Set Process Pool
        if (!_webProcessPool) {
            static WKProcessPool *sWKProcessPool;
            static dispatch_once_t onceToken;
            dispatch_once(&onceToken, ^{
                sWKProcessPool = [[WKProcessPool alloc] init];
            });
            _webConfig.processPool = sWKProcessPool;
        }
        
        // Set Preference
        if (!_webPreference) {
            _webConfig.preferences = _webPreference;
        }
        
        WKUserContentController* userController = [[WKUserContentController alloc] init];
        
        // Add Javascript Message Handler
        [userController addScriptMessageHandler:selfObject
                                           name:javascriptNamespace];
        
        _webConfig.ignoresViewportScaleLimits = NO;
        _webConfig.suppressesIncrementalRendering = YES;
        _webConfig.allowsInlineMediaPlayback = YES;
        _webConfig.allowsAirPlayForMediaPlayback = YES;
        _webConfig.allowsPictureInPictureMediaPlayback = YES;
        _webConfig.mediaTypesRequiringUserActionForPlayback = YES;
        _webConfig.userContentController = userController;
    }
    
    return _webConfig;
}

+(WKWebView *) webViewObj :(WKWebView *) _wkWebView :(id) selfObject :(WKPreferences *) _webPreference :(WKProcessPool *) _webProcessPool :(WKWebViewConfiguration *) _webConfig :(NSString *) javascriptNamespace :(UIView *)view {
    
    if (!_wkWebView) {
        //view.frame
        _wkWebView = [[WKWebView alloc] initWithFrame:CGRectMake(0, 0, 0, 0)
                                        configuration:
                      [self webConfig:_webPreference
                                     :_webProcessPool
                                     :_webConfig
                                     :selfObject
                                     :javascriptNamespace
                       ]];
        _wkWebView.autoresizingMask = UIViewAutoresizingFlexibleHeight; // UIViewAutoresizingFlexibleWidth |
        
        // Delegate
        _wkWebView.navigationDelegate = selfObject;
        _wkWebView.UIDelegate = selfObject;
        
        _wkWebView.backgroundColor = [UIColor clearColor];
        _wkWebView.allowsBackForwardNavigationGestures = YES;
        _wkWebView.autoresizesSubviews = YES;
        _wkWebView.multipleTouchEnabled = YES;
        _wkWebView.opaque = NO;
        _wkWebView.contentMode = UIViewContentModeRedraw;
        
        // Layer
        _wkWebView.layer.borderWidth = 0;
        _wkWebView.layer.masksToBounds = YES;
        
        // ScrollView
        _wkWebView.scrollView.contentInset = UIEdgeInsetsZero;
        _wkWebView.scrollView.bounces = NO;
        
        // Translate
        _wkWebView.translatesAutoresizingMaskIntoConstraints = NO;
        
        if (@available(iOS 11.0, *)) {
            _wkWebView.scrollView.contentInsetAdjustmentBehavior = UIScrollViewContentInsetAdjustmentAutomatic;
        }
    }
    
    return _wkWebView;
}

+ (void)setZoomLevel_:(WKWebView *) webView :(id)zoomLevel {
    [webView evaluateJavaScript:[NSString stringWithFormat:@"document.body.style.zoom = %@;", zoomLevel]
              completionHandler:nil];
}

+ (void) evaluteUserAgentChangeCompletionHandler:(WKWebView *) webView :(void (^ _Nullable)(_Nullable id, NSError * _Nullable error))completionHandler {
    [self evaluteWithCompletionHandler:webView
                                      :@"navigator.userAgent"
                                      :completionHandler];
}

+ (void) evalute:(WKWebView *) webView :(NSString *) script {
    [webView evaluateJavaScript:script completionHandler:nil];
}

+ (void) evaluteWithCompletionHandler:(WKWebView *) webView :(NSString *) script :(void (^ _Nullable)(_Nullable id, NSError * _Nullable error))completionHandler {
    [webView evaluateJavaScript:script completionHandler:completionHandler];
}

+ (void)loadURL:(NSString *) url :(WKWebView *) webView {
    NSURLRequest *request = [[NSURLRequest alloc] initWithURL:[NSURL URLWithString:url]];
    [webView loadRequest:request];
}

+ (void)loadHTMLString:(WKWebView *) webView :(NSString *)HTMLString {
    [webView loadHTMLString:HTMLString baseURL:nil];
}

+ (WKUserScript *)userScriptDisableZoom {
    NSString *source = @"var meta = document.createElement('meta'); \
    meta.setAttribute('name', 'viewport'); \
    meta.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'); \
    var head = document.getElementsByTagName('head')[0]; \
    head.appendChild(meta);";
    
    return [[WKUserScript alloc] initWithSource:source
                                  injectionTime:WKUserScriptInjectionTimeAtDocumentEnd
                               forMainFrameOnly:YES];
}

// http://stackoverflow.com/a/32765708/5537752
+ (NSString *)mimeTypeForData:(NSData *)data {
    uint8_t c;
    [data getBytes:&c length:1];
    
    switch (c) {
        case 0xFF:
            return @"image/jpeg";
            break;
        case 0x89:
            return @"image/png";
            break;
        case 0x47:
            return @"image/gif";
            break;
        case 0x49:
        case 0x4D:
            return @"image/tiff";
            break;
        case 0x25:
            return @"application/pdf";
            break;
        case 0xD0:
            return @"application/vnd";
            break;
        case 0x46:
            return @"text/plain";
            break;
        default:
            return @"application/octet-stream";
    }
    
    return nil;
}

+ (WKUserScript *)userScriptDisableContextMenu {
    NSString *source = @"var style = document.createElement('style'); \
    style.type = 'text/css'; \
    style.innerText = '*:not(input):not(textarea) { -webkit-user-select: none; -webkit-touch-callout: none; }'; \
    var head = document.getElementsByTagName('head')[0]; \
    head.appendChild(style);";
    
    return [[WKUserScript alloc] initWithSource:source
                                  injectionTime:WKUserScriptInjectionTimeAtDocumentEnd
                               forMainFrameOnly:YES];
}

+ (WKUserScript *) userScriptScalesPageToFit {
    NSString *source = @"var meta = document.createElement('meta'); \
    meta.setAttribute('name', 'viewport'); \
    meta.setAttribute('content', 'width=device-width, initial-scale=1, maximum-scale=1'); \
    var head = document.getElementsByTagName('head')[0]; \
    head.appendChild(meta);";
    
    return [[WKUserScript alloc] initWithSource:source
                                  injectionTime:WKUserScriptInjectionTimeAtDocumentEnd
                               forMainFrameOnly:YES];
}

+ (void)setURL :(NSString *) requestURLString :(WKWebView *) webView {
    NSURL *url = [[NSURL alloc] initWithString: requestURLString];
    NSURLRequest *request = [[NSURLRequest alloc] initWithURL: url
                                                  cachePolicy: NSURLRequestUseProtocolCachePolicy
                                              timeoutInterval: 5];
    
    [webView loadRequest: request];
}

+ (WKWebViewConfiguration *)setJS:(id)selfObject {
    NSString *jsString = @"";
    WKUserScript *userScript = [[WKUserScript alloc] initWithSource: jsString
                                                      injectionTime: WKUserScriptInjectionTimeAtDocumentEnd
                                                   forMainFrameOnly:YES];
    WKUserContentController *wkUController = [WKUserContentController new];
    [wkUController addUserScript: userScript];
    [wkUController addScriptMessageHandler:selfObject
                                      name:@"callbackHandler"];
    
    WKWebViewConfiguration *wkWebConfig = [WKWebViewConfiguration new];
    wkWebConfig.userContentController = wkUController;
    
    return wkWebConfig;
}

+ (void)triggerJS:(NSString *)jsString webView:(WKWebView *)webView {
    [webView evaluateJavaScript:jsString
              completionHandler:^(NSString *result, NSError *error){
        if (error != nil) {
            NSLog(@"JS실행시의 에러：%@", error.localizedDescription);
            return;
        }
        NSLog(@"출력 결과：%@", result);
    }];
}

@end
