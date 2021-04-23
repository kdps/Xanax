
infix operator <-< : AssignmentPrecedence
func <-< <T:AnyObject> (object:T, closure:(T)->()) -> Void {
    closure(object)
}

extension HasApply {
    func apply(closure:(Self) -> ()) -> Self {
        closure(self)
        return self
    }
}

extension NSObject: HasApply { }

class Span: Comparable {
    var start: Int = 0
    var end: Int = 0

    static func < (lhs: Span, rhs: Span) -> Bool {
        return lhs.start < rhs.start
    }

    static func == (lhs: Span, rhs: Span) -> Bool {
        return lhs.start == rhs.start
    }
}
