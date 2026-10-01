using System.Text;

namespace scsc
{
    public class PCharToken : Token
    {
        public PCharToken(int line, int column) : base(line, column) { }

        public override string ToString()
        {
            StringBuilder s = new StringBuilder();
            s.AppendFormat("line {0}, column {1}: {2} - {3}", line, column, "pchar", GetType());
            return s.ToString();
        }
    }
}
