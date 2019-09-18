Text -> Lexer -> (Emit) Tokens -> Parser - > Syntax Tree -> Evaluator -> Behaviour


Lexer Example

Foo = "bar";

->

("symbol", "foo") -> Object or Array

("=", "")

("string", "bar")

(",", "")

200 - 198

("number", "200")

("-", "")

("number", "198")
