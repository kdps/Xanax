import Foundation
import UIKit
import SwiftyJSON
import AVFoundation
import Alamofire

class Alerts {
    
    /*
     var actions: [(String, UIAlertActionStyle)] = []
         actions.append(("Action 1", UIAlertActionStyle.default))
         actions.append(("Action 2", UIAlertActionStyle.destructive))
         actions.append(("Action 3", UIAlertActionStyle.cancel))

         //self = ViewController
         Alerts.showActionsheet(viewController: self, title: "D_My ActionTitle", message: "General Message in Action Sheet", actions: actions) { (index) in
             print("call action \(index)")
             
         }

     */
    static func showActionsheet(viewController: UIViewController, title: String, message: String, actions: [(String, UIAlertAction.Style)], completion: @escaping (_ index: Int) -> Void) {
    let alertViewController = UIAlertController(title: title, message: message, preferredStyle: .actionSheet)
    for (index, (title, style)) in actions.enumerated() {
        let alertAction = UIAlertAction(title: title, style: style) { (_) in
            completion(index)
        }
        alertViewController.addAction(alertAction)
     }
     viewController.present(alertViewController, animated: true, completion: nil)
    }
}

var player: AVAudioPlayer?

class Utility {
    
    static func doRequest(_ url: URLConvertible, method: HTTPMethod = .get, parameters: Parameters? = nil, encoding: ParameterEncoding = URLEncoding.default, headers: HTTPHeaders? = nil, completionHandler: @escaping (DataResponse<Any>) -> Void) {
        Alamofire.request(url, method: method, parameters: parameters, encoding: encoding)
            .validate(statusCode: 200..<300)
            .validate(contentType: ["application/json"])
            .responseJSON(completionHandler: completionHandler)
    }
    
    static func playSoundWithFilename(filename: String) {
        let filename = filename.components(separatedBy: ".")
        
        playSound(name: filename[0], extensions: filename[1])
    }
    
    static func playSound(name: String, extensions: String) {
        guard let url = Bundle.main.url(forResource: name, withExtension: extensions) else {
            return
        }

        do {
            try AVAudioSession.sharedInstance().setCategory(.playback, mode: .default)
            try AVAudioSession.sharedInstance().setActive(true)

            /* The following line is required for the player to work on iOS 11. Change the file type accordingly*/
            player = try AVAudioPlayer(contentsOf: url, fileTypeHint: AVFileType.mp3.rawValue)

            /* iOS 10 and earlier require the following line:
            player = try AVAudioPlayer(contentsOf: url, fileTypeHint: AVFileTypeMPEGLayer3) */

            guard let player = player else {
                return
            }

            player.play()

        } catch let error {
            print(error.localizedDescription)
        }
    }
    
    static func displaySoundsAlertSheet(_self: Any) {
        let controller = UIAlertController(title: nil, message: nil, preferredStyle: UIAlertController.Style.actionSheet)

        for item in 1000...1100 {
            controller.addAction(UIAlertAction(title: "Option \(item)", style: UIAlertAction.Style.default, handler: { action in
                AudioServicesPlayAlertSound(UInt32(item))
                self.displaySoundsAlertSheet(_self: _self)
            }))
        }
        controller.addAction(UIAlertAction(title: "Cancel", style: UIAlertAction.Style.cancel, handler: nil))

        (_self as AnyObject).present(controller, animated: true, completion: nil)
    }
    
    // https://github.com/TUNER88/iOSSystemSoundsLibrary
    static func displaySoundsAlert(_self: Any) {
        let alert = UIAlertController(title: "Play Sound", message: nil, preferredStyle: UIAlertController.Style.alert)
        for i in 1106...1115 {
            alert.addAction(UIAlertAction(title: "\(i)", style: .default, handler: {_ in
                AudioServicesPlayAlertSound(UInt32(i))
                self.displaySoundsAlert(_self: _self)
            }))
        }
        alert.addAction(UIAlertAction(title: "Cancel", style: .cancel, handler: nil))
        (_self as AnyObject).present(alert, animated: true, completion: nil)
    }
    
    static func playSystemSound(id: SystemSoundID) {
        AudioServicesPlaySystemSound(UInt32(id))
    }
    
    static func Beep() {
        let systemSoundID: SystemSoundID = 1115

        // to play sound
        AudioServicesPlaySystemSound (systemSoundID)
    }
    
    static func UIColorFromRGB(rgbValue: UInt, alpha: Float) -> UIColor {
        return UIColor(
            red: CGFloat((rgbValue & 0xFF0000) >> 16) / 255.0,
            green: CGFloat((rgbValue & 0x00FF00) >> 8) / 255.0,
            blue: CGFloat(rgbValue & 0x0000FF) / 255.0,
            alpha: CGFloat(alpha)
        )
    }
    
    //let notificationCenter = UNUserNotificationCenter.current()
    //Utility.scheduleNotification(title: "test", message: "message", badgeCount: 1, notificationCenter: notificationCenter)
    static func scheduleNotification(title: String, message: String, badgeCount: NSNumber, notificationCenter: UNUserNotificationCenter) {
        notificationCenter.requestAuthorization(options: [.alert, .badge]) {
            (granted, error) in
            if granted {
                print("Notification permission is granted")
            } else {
                print("Notification permission is not granted") // Print this, not authorized
            }
        }
        
        let content = UNMutableNotificationContent()
        let userActions = "User Actions"
        
        content <-< {
            $0.title = title
            $0.body = message
            $0.sound = UNNotificationSound.default
            $0.badge = badgeCount
            $0.categoryIdentifier = userActions
        }
        
        let trigger = UNTimeIntervalNotificationTrigger(timeInterval: 5, repeats: false)
        let identifier = "Local Notification"
        let request = UNNotificationRequest(identifier: identifier, content: content, trigger: trigger)
        
        notificationCenter.add(request) { (error) in
            if let error = error {
                print("Error \(error.localizedDescription)")
            }
        }
        
        let snoozeAction = UNNotificationAction(identifier: "Snooze", title: "Snooze", options: [])
        let deleteAction = UNNotificationAction(identifier: "Delete", title: "Delete", options: [.destructive])
        let category = UNNotificationCategory(identifier: userActions, actions: [snoozeAction, deleteAction], intentIdentifiers: [], options: [])
        
        notificationCenter.setNotificationCategories([category])
    }
    
    static func showUniversalLoadingView(_ show: Bool, loadingText : String = "", tag: Int = 1200) {
        let existingView = UIApplication.shared.windows[0].viewWithTag(tag)
        
        if show {
            if existingView != nil {
                let label = existingView?.viewWithTag(1234) as! UILabel
                label.text = loadingText
                
                return
            }
            
            let loadingView = self.makeLoadingView(withFrame: UIScreen.main.bounds, loadingText: loadingText)
            loadingView?.tag = tag
            UIApplication.shared.windows[0].addSubview(loadingView!)
        } else {
            existingView?.removeFromSuperview()
        }

    }

    static func UIColorFromRGB(rgbValue: UInt) -> UIColor {
        return UIColor(
            red: CGFloat((rgbValue & 0xFF0000) >> 16) / 255.0,
            green: CGFloat((rgbValue & 0x00FF00) >> 8) / 255.0,
            blue: CGFloat(rgbValue & 0x0000FF) / 255.0,
            alpha: CGFloat(1.0)
        )
    }
    
    static var screenWidth: CGFloat {
        return UIScreen.main.bounds.width
    }

    static var screenHeight: CGFloat {
        return UIScreen.main.bounds.height
    }

    static func makeLoadingView(withFrame frame: CGRect, loadingText text: String?) -> UIView? {
        let loadingView = UIView(frame: frame)
        loadingView.backgroundColor = UIColor(red: 0, green: 0, blue: 0, alpha: 0.5)
        let activityIndicator = UIActivityIndicatorView(frame: CGRect(x: 0, y: 0, width: screenWidth - 20, height: 100))
        
        activityIndicator <-< {
            $0.backgroundColor = UIColor(red:255, green:255, blue:255, alpha:0.5)
            $0.layer.cornerRadius = 6
            $0.layer.shadowColor = UIColor.black.cgColor
            $0.layer.shadowRadius = 0
            $0.layer.shadowOffset = CGSize(width: 5, height: 7)
            $0.center = loadingView.center
            $0.hidesWhenStopped = true
            $0.style = .whiteLarge
            $0.startAnimating()
            $0.color = UIColor.gray
            $0.tag = 100 // 100 for example
        }

        loadingView.addSubview(activityIndicator)
        
        if !text!.isEmpty {
            let x = activityIndicator.frame.origin.x + activityIndicator.frame.size.width / 2
            let y = activityIndicator.frame.origin.y + 80
            
            let cpoint = CGPoint(x: x, y: y)
            let lbl = UILabel(frame: CGRect(x: 0, y: 0, width: screenWidth - 20, height: 30))
            
            lbl <-< {
                $0.center = cpoint
                $0.textColor = UIColor.black
                $0.textAlignment = .center
                $0.text = text
                $0.tag = 1234
                $0.font = $0.font.withSize(14)
            }
            
            loadingView.addSubview(lbl)
        }
        
        return loadingView
    }
    
    static func fireNotification() {
        let mutable = UNMutableNotificationContent()
            mutable.body = "message"
            mutable.title = "title"

            var date = DateComponents()
            date.hour = 16
            date.minute = 52
            date.month = 6
            date.day = 20
            date.year = 2019

            let trigger = UNCalendarNotificationTrigger(dateMatching: date, repeats: false)
            let request = UNNotificationRequest(identifier: "key", content: mutable, trigger: trigger)
            UNUserNotificationCenter.current().add(request)
    }
    
    static func Speech(text: String, delegater: AVSpeechSynthesizerDelegate?) {
        let synthesizer = AVSpeechSynthesizer()
        let utterance = AVSpeechUtterance(string: text)
        utterance.voice = AVSpeechSynthesisVoice(language: "ko-KR")
        utterance.rate = 0.4
        synthesizer.delegate = delegater
        synthesizer.speak(utterance)
        
    }
    
    static func URLMake(_ url: String, _ params: [String:String]) -> String {
        var result : String = url + "?"
        
        for (key, value) in params {
            result = result + key + "=" + value + "&"
        }
        
        return result;
    }
    
    static func makeClosure(fnc: Any) -> () -> () {
        var cancelHandler: () -> ()
        cancelHandler = fnc as! () -> ()
        
        return cancelHandler
    }
    
    static func DeviceUUID() -> String {
        return UIDevice.current.identifierForVendor!.uuidString;
    }
    
    static func AppVersion() -> String {
        return (Bundle.main.infoDictionary?["CFBundleShortVersionString"] as? String)!
    }
    
    static func CommaWon(_ data: String) -> String {
        let numberFormatter = NumberFormatter()
        numberFormatter.numberStyle = .decimal
        
        let price = Double(data)!
        let result = numberFormatter.string(from: NSNumber(value:price))!
        
        return result
    }
    
    static func showConfirmWithText(_self: Any, title: String, message: String, confirm: String, cancel: String, confirmHandler: ((_ text: String?) -> Void)? = nil, cancelHandler: ((UIAlertAction) -> Swift.Void)? = nil, defaultTextField: String? = nil, inputKeyboardType: UIKeyboardType = UIKeyboardType.default, inputPlaceholder: String? = nil, style: UIAlertController.Style = UIAlertController.Style.alert) -> Void {
        let alert = UIAlertController(title: title, message:message, preferredStyle: style)

        alert <-< {
            $0.addTextField { (textField) in
                textField <-< {
                    $0.text = defaultTextField
                    $0.placeholder = inputPlaceholder
                    $0.keyboardType = inputKeyboardType
                    $0.delegate = _self as? UITextFieldDelegate
                }
            }
            $0.addAction(UIAlertAction(title: confirm, style: UIAlertAction.Style.default, handler: { (action:UIAlertAction) in
                guard let textField =  alert.textFields?.first else {
                    confirmHandler?(nil)
                    return
                }
                
                confirmHandler?(textField.text)
            }))
            $0.addAction(UIAlertAction(title: cancel, style: UIAlertAction.Style.destructive, handler: cancelHandler))
        }
            
        (_self as AnyObject).present(alert, animated: true, completion: nil)
    }
    
    static func showConfirm(_self:Any, title: String, message: String, confirm: String, cancel: String, confirmHandler: ((UIAlertAction) -> Swift.Void)? = nil, cancelHandler: ((UIAlertAction) -> Swift.Void)? = nil, style: UIAlertController.Style = UIAlertController.Style.alert) -> Void {
        let alert = UIAlertController(title: title, message:message, preferredStyle: style)

        alert <-< {
            $0.addAction(UIAlertAction(title: confirm, style: UIAlertAction.Style.default, handler: confirmHandler))
            $0.addAction(UIAlertAction(title: cancel, style: UIAlertAction.Style.destructive, handler: cancelHandler))
        }
            
        (_self as AnyObject).present(alert, animated: true, completion: nil)
    }
    
    static func strZeroFill(_ str: String) -> String {
        let number: Int = Int(str)!
        
        return String(format: "%02d", number)
    }
    
    //    static func setUserInfo(_ json: JSON) {
    //        UserDefaults.standard.set(json["idx"].stringValue, forKey: .idx)
    //        UserDefaults.standard.set(json["id"].stringValue, forKey: .id)
    //        UserDefaults.standard.set(json["email"].stringValue, forKey: .email)
    //        UserDefaults.standard.set(json["name"].stringValue, forKey: .name)
    //        UserDefaults.standard.set(json["nickName"].stringValue, forKey: .nickName)
    //        UserDefaults.standard.set(json["phone"].stringValue, forKey: .phone)
    //        UserDefaults.standard.set(json["tel"].stringValue, forKey: .tel)
    //        UserDefaults.standard.set(json["level"].stringValue, forKey: .level)
    //        UserDefaults.standard.set(json["memo"].stringValue, forKey: .memo)
    //        UserDefaults.standard.set(json["thumb"].stringValue, forKey: .thumb)
    //
    //        if(json["level"].stringValue == "2") {
    //            UserDefaults.standard.set(json["shopName"].stringValue, forKey: .shopName)
    //            UserDefaults.standard.set(json["shopNumber"].stringValue, forKey: .shopNumber)
    //        }
    //    }
    
    static func imageWithColor(_ color : UIColor) -> UIImage {
        let rect = CGRect(x: 0.0, y: 0.0, width: 1.0, height: 1.0)
        UIGraphicsBeginImageContext(rect.size)
        
        guard let context: CGContext = UIGraphicsGetCurrentContext() else {
            return UIImage();
        }
        
        context <-< {
            $0.setFillColor(color.cgColor)
            $0.fill(rect)
        }
        
        guard let image: UIImage = UIGraphicsGetImageFromCurrentImageContext() else {
            return UIImage();
        }
        
        UIGraphicsEndImageContext()
        
        return image
    }
    
    static func getConstraint(_ view: UIView, identifier: String) -> NSLayoutConstraint {
        for (const):(NSLayoutConstraint) in view.constraints {
            if const.identifier == identifier {
                return const
            }
        }
        
        return NSLayoutConstraint()
    }
    
    static func alert(controller:UIViewController, title: String, content: String) {
        let alertController = UIAlertController(title: title, message: content, preferredStyle: UIAlertController.Style.alert)
        let button = UIAlertAction(title: "확인", style: UIAlertAction.Style.default, handler: nil)
        
        alertController.addAction(button)
        
        controller.present(alertController,animated: true,completion: nil)
    }
    
    static func alert(controller:UIViewController, title: String, content: String, handler: ((UIAlertAction) -> Swift.Void)? = nil) {
        let alertController = UIAlertController(title: title, message: content, preferredStyle: UIAlertController.Style.alert)
        let button = UIAlertAction(title: "확인", style: UIAlertAction.Style.default, handler: handler)
        
        alertController.addAction(button)
        
        controller.present(alertController,animated: true,completion: nil)
    }
    
    static func confirm(controller:UIViewController, title: String, handler: ((UIAlertAction) -> Swift.Void)? = nil) {
        let alert: UIAlertController = UIAlertController(title: nil, message: nil, preferredStyle:  UIAlertController.Style.actionSheet)
        let informantAction: UIAlertAction = UIAlertAction(title: title, style: UIAlertAction.Style.destructive, handler:handler)
        let cancelAction: UIAlertAction = UIAlertAction(title: "취소", style: UIAlertAction.Style.cancel, handler:nil)
        
        alert <-< {
            $0.addAction(cancelAction)
            $0.addAction(informantAction)
            $0.popoverPresentationController?.sourceView = controller.view
        }
        
        controller.present(alert, animated: true, completion: nil)
    }
    
    static func confirm(controller:UIViewController, title: String, message: String, handler: ((UIAlertAction) -> Swift.Void)? = nil) {
        let alert: UIAlertController = UIAlertController(title: title, message: message, preferredStyle:  UIAlertController.Style.actionSheet)
        let informantAction: UIAlertAction = UIAlertAction(title: "확인", style: UIAlertAction.Style.destructive, handler:handler)
        let cancelAction: UIAlertAction = UIAlertAction(title: "취소", style: UIAlertAction.Style.cancel, handler:nil)
        
        alert <-< {
            $0.addAction(cancelAction)
            $0.addAction(informantAction)
            $0.popoverPresentationController?.sourceView = controller.view
        }
        
        controller.present(alert, animated: true, completion: nil)
    }
    
    static func getHtmlString(str: String) -> NSAttributedString {
        
        let data = str.data(using: String.Encoding.unicode)! // mind "!"
        let attrStr = try? NSAttributedString( // do catch
            data: data,
            options: [NSAttributedString.DocumentReadingOptionKey.documentType: NSAttributedString.DocumentType.html],
            documentAttributes: nil)
        
        return attrStr!
    }
    
    static func getToday() -> String {
        let date = Date()
        let formatter = DateFormatter()
        formatter.dateFormat = "yyyy-MM-dd"
        
        return formatter.string(from: date)
    }
    
    static func getTime() -> String {
        let date = Date()
        let formatter = DateFormatter()
        formatter.dateFormat = "yyyy-MM-dd HH:mm:ss"
        
        return formatter.string(from: date)
    }
    
    static func getHanDate(_ str: String) -> String {
        var result = ""
        
        if(str.isEmpty) {
            return result
        }
        
        var temp = Date()
        let formatter = DateFormatter()
        formatter <-< {
            $0.dateFormat = "yyyy-MM-dd HH:mm:ss"
            temp = $0.date(from: str)!
        }
        
        let formatter2 = DateFormatter()
        formatter2 <-< {
            $0.dateFormat = "MM월 dd일"
            result = $0.string(from: temp)
        }
        
        return result
    }
    
    static func getURL(_ url: String) -> URL {
        var result = url
        if(url.contains("http://") || url.contains("https://")) {
            result = url
        } else {
            result = GlobalDataManager.URL + url
        }
        
        return URL(string: result)!
    }
    
    static func linkURL(url: String) {
        if let url = URL(string: url) {
            UIApplication.shared.open(url, options: [:], completionHandler: nil)
        }
    }
    
    static func actionTel(tel: String) {
        if let phoneCallURL = URL(string: "tel://\(tel)") {
            let application:UIApplication = UIApplication.shared
            
            application <-< {
                if ($0.canOpenURL(phoneCallURL)) {
                    $0.open(phoneCallURL, options: [:], completionHandler: nil)
                }
            }
        }
    }
    
    static func printError(_ view: UIView, error: Error) {
        switch error._code {
        case -1009 :
            view.makeToast("네트워크 연결이 불안하거나 차단된 상태입니다.")
            break;
        default :
            view.makeToast(GlobalDataManager.ERROR_MSG)
            break;
        }
    }
        
    static func getAttributedString(_ color: UInt, font: String, size: CGFloat) -> [NSAttributedString.Key : Any] {
        return [
            NSAttributedString.Key.foregroundColor : Utility.UIColorFromRGB(rgbValue: color, alpha: 1.0),
            NSAttributedString.Key.font : UIFont(name: font, size: size) as Any
        ]
    }
    
    static func getAttributedString(_ color: UInt, size: CGFloat) -> [NSAttributedString.Key : Any] {
        return getAttributedString(color, font: "NotoSansKR-Regular", size: size)
    }
    
    static func setGradient(_ view: UIView, startColor: UInt, endColor: UInt) {
        let gradient: CAGradientLayer = CAGradientLayer()
        gradient <-< {
            $0.colors = [startColor, endColor]
            $0.locations = [0.0 , 1.0]
            $0.frame = view.layer.frame
        }
        
        view.layer.insertSublayer(gradient, at: 0)
    }
    
    static func getGradientColor(from colors: [UIColor], size: CGSize) -> UIColor {
        let image = UIGraphicsImageRenderer(bounds: CGRect(x: 0, y: 0, width: size.width, height: size.height)).image { context in
            let cgColors = colors.map { $0.cgColor } as CFArray
            let colorSpace = CGColorSpaceCreateDeviceRGB()
            let gradient = CGGradient(
                colorsSpace: colorSpace,
                colors: cgColors,
                locations: [0.0 , 1.0]
            )!
            context.cgContext.drawLinearGradient(
                gradient,
                start: CGPoint(x: 0, y: 0),
                end: CGPoint(x: size.width, y: size.height),
                options:[]
            )
        }
        return UIColor(patternImage: image)
    }

}

@IBDesignable
class RoundedButton: UIButton {
    @IBInspectable var borderWidth: CGFloat = 1.0
    @IBInspectable var cornerRadious: CGFloat = 4
    @IBInspectable var borderColor: UIColor = Utility.UIColorFromRGB(rgbValue: 0xD8D8D8, alpha: 1.0)
    
    required init?(coder aDecoder: NSCoder) {
        super.init(coder: aDecoder)
    }
    
    override init(frame: CGRect) {
        super.init(frame: frame)
    }
    
    override func draw(_ rect: CGRect) {
        super.draw(rect);
        
        layer <-< {
            $0.cornerRadius = cornerRadious
            $0.borderColor = borderColor.cgColor
            $0.borderWidth = borderWidth
            $0.masksToBounds = true
        }
        
    }
}
