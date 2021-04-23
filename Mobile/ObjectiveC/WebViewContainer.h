#import <Foundation/Foundation.h>
#import <UIKit/UIKit.h>
#import <WebKit/WebKit.h>

@interface WebViewContainer : NSObject

+(WKWebViewConfiguration *) webConfig :(WKPreferences *) _webPreference :(WKProcessPool *) _webProcessPool :(WKWebViewConfiguration *) _webConfig :(id) selfObject :(NSString *) javascriptNamespace;
+(WKWebView *) webViewObj :(WKWebView *) _wkWebView: (id) selfObject :(WKPreferences *) _webPreference :(WKProcessPool *) _webProcessPool :(WKWebViewConfiguration *) _webConfig :(NSString *) javascriptNamespace :(UIView *)view;
+ (NSString *) mimeTypeForData:(NSData *)data;
+ (WKUserScript *)userScriptDisableContextMenu;
+ (WKUserScript *)userScriptDisableZoom;
+ (WKUserScript *) userScriptScalesPageToFit;
+ (void)setZoomLevel_:(WKWebView *) webView :(id)zoomLevel;

+ (void)loadURL:(NSString *) url :(WKWebView *) webView;
+ (void)loadHTMLString:(WKWebView *) webView :(NSString *)HTMLString;
+ (void)triggerJS:(NSString *)jsString webView:(WKWebView *)webView;
+ (void)setURL:(NSString *) requestURLString :(WKWebView *) webView;
+ (WKWebViewConfiguration *)setJS:(id)selfObject;
+ (void) evalute:(WKWebView *) webView :(NSString *) script;
+ (void) evaluteUserAgentChangeCompletionHandler:(WKWebView *) webView :(void (^ _Nullable)(_Nullable id, NSError * _Nullable error))completionHandler;
+ (void) evaluteWithCompletionHandler:(WKWebView *) webView :(NSString *_Nullable) script :(void (^ _Nullable)(_Nullable id, NSError * _Nullable error)) completionHandler;

- (IBAction)refresh: (id)sender :(WKWebView *_Nullable) webView;
- (IBAction)forword: (id)sender :(WKWebView *_Nullable) webView;
- (IBAction)back: (id)sender :(WKWebView *) webView;

@end
