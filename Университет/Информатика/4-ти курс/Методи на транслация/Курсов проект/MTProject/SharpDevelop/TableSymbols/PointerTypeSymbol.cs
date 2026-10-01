using System;

namespace scsc
{
    public class PointerTypeSymbol : TypeSymbol
    {
        public PointerTypeSymbol(IdentToken token, Type pointedType) : base(token, pointedType.MakePointerType()) { }
    }
}
