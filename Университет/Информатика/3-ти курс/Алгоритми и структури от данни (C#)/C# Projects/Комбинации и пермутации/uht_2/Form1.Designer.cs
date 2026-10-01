namespace uht_2
{
    partial class Form1
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.tbIn = new System.Windows.Forms.TextBox();
            this.label1 = new System.Windows.Forms.Label();
            this.btnPermIterat = new System.Windows.Forms.Button();
            this.btnPermRecurs = new System.Windows.Forms.Button();
            this.tbOut = new System.Windows.Forms.TextBox();
            this.button1 = new System.Windows.Forms.Button();
            this.label2 = new System.Windows.Forms.Label();
            this.tbInK = new System.Windows.Forms.TextBox();
            this.button2 = new System.Windows.Forms.Button();
            this.SuspendLayout();
            // 
            // tbIn
            // 
            this.tbIn.Location = new System.Drawing.Point(41, 20);
            this.tbIn.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.tbIn.Name = "tbIn";
            this.tbIn.Size = new System.Drawing.Size(32, 20);
            this.tbIn.TabIndex = 0;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(19, 22);
            this.label1.Margin = new System.Windows.Forms.Padding(2, 0, 2, 0);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(19, 13);
            this.label1.TabIndex = 1;
            this.label1.Text = "n=";
            // 
            // btnPermIterat
            // 
            this.btnPermIterat.Location = new System.Drawing.Point(179, 17);
            this.btnPermIterat.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.btnPermIterat.Name = "btnPermIterat";
            this.btnPermIterat.Size = new System.Drawing.Size(56, 19);
            this.btnPermIterat.TabIndex = 2;
            this.btnPermIterat.Text = "P Iterat";
            this.btnPermIterat.UseVisualStyleBackColor = true;
            this.btnPermIterat.Click += new System.EventHandler(this.btnPermIterat_Click);
            // 
            // btnPermRecurs
            // 
            this.btnPermRecurs.Location = new System.Drawing.Point(239, 17);
            this.btnPermRecurs.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.btnPermRecurs.Name = "btnPermRecurs";
            this.btnPermRecurs.Size = new System.Drawing.Size(56, 19);
            this.btnPermRecurs.TabIndex = 3;
            this.btnPermRecurs.Text = "P recurs";
            this.btnPermRecurs.UseVisualStyleBackColor = true;
            this.btnPermRecurs.Click += new System.EventHandler(this.btnPermRecurs_Click);
            // 
            // tbOut
            // 
            this.tbOut.Font = new System.Drawing.Font("Microsoft Sans Serif", 14F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(204)));
            this.tbOut.Location = new System.Drawing.Point(9, 50);
            this.tbOut.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.tbOut.Multiline = true;
            this.tbOut.Name = "tbOut";
            this.tbOut.ScrollBars = System.Windows.Forms.ScrollBars.Vertical;
            this.tbOut.Size = new System.Drawing.Size(445, 414);
            this.tbOut.TabIndex = 4;
            // 
            // button1
            // 
            this.button1.Location = new System.Drawing.Point(324, 19);
            this.button1.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.button1.Name = "button1";
            this.button1.Size = new System.Drawing.Size(56, 21);
            this.button1.TabIndex = 5;
            this.button1.Text = "Comb It";
            this.button1.UseVisualStyleBackColor = true;
            this.button1.Click += new System.EventHandler(this.button1_Click);
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(85, 22);
            this.label2.Margin = new System.Windows.Forms.Padding(2, 0, 2, 0);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(19, 13);
            this.label2.TabIndex = 6;
            this.label2.Text = "k=";
            // 
            // tbInK
            // 
            this.tbInK.Location = new System.Drawing.Point(106, 20);
            this.tbInK.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.tbInK.Name = "tbInK";
            this.tbInK.Size = new System.Drawing.Size(36, 20);
            this.tbInK.TabIndex = 7;
            // 
            // button2
            // 
            this.button2.Location = new System.Drawing.Point(385, 19);
            this.button2.Name = "button2";
            this.button2.Size = new System.Drawing.Size(65, 21);
            this.button2.TabIndex = 8;
            this.button2.Text = "comb rec";
            this.button2.UseVisualStyleBackColor = true;
            this.button2.Click += new System.EventHandler(this.button2_Click);
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(462, 473);
            this.Controls.Add(this.button2);
            this.Controls.Add(this.tbInK);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.button1);
            this.Controls.Add(this.tbOut);
            this.Controls.Add(this.btnPermRecurs);
            this.Controls.Add(this.btnPermIterat);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.tbIn);
            this.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.Name = "Form1";
            this.Text = "Permutations & Combinations";
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.TextBox tbIn;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Button btnPermIterat;
        private System.Windows.Forms.Button btnPermRecurs;
        private System.Windows.Forms.TextBox tbOut;
        private System.Windows.Forms.Button button1;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.TextBox tbInK;
        private System.Windows.Forms.Button button2;
    }
}

