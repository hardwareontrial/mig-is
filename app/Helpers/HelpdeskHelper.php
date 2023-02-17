<?php
    namespace App\Helpers;

    class HelpdeskHelper{
        /*  --- Start SAP BP Helper   --  */
        public static function BpGrouping(){
            return (array(  ["code"=>"Z001",
                             "desc"=>"Local Trade 3rd Party"],
                            ["code"=>"Z002",
                             "desc"=>"Foreign Trade 3rd Party"],
                            ["code"=>"Z003",
                             "desc"=>"Local Non Trade 3rd Party"],
                            ["code"=>"Z004",
                             "desc"=>"Foreign Non Trade 3rd Party"],
                            ["code"=>"Z005",
                             "desc"=>"Related Party Trade"],
                            ["code"=>"Z006",
                             "desc"=>"Related Party Non Trade"],
                            ["code"=>"Z007",
                             "desc"=>"Sales Agents"],                            
                            ["code"=>"Z008",
                             "desc"=>"Ship-to-Party"],
                            ["code" =>"Z009",
                             "desc"=>"Employee"]
                        ));
        }
        
        public static function BpBank(){
            return (array(  "bank"=>"BCA",
                            "bank"=>"MANDIRI",
                            "bank"=>"BNI",
                            "bank"=>"BRI"                            
                        ));
        }
        public static function BpTop(){
            return (array(  ["code"=>"Z000", "desc"=>"Cash"],
                            ["code"=>"Z001","desc"=>"Cash TT Before Delivery"],
                            ["code"=>"Z002","desc"=>"02 Days Credit"],
                            ["code"=>"Z007","desc"=>"07 Days Credit"],
                            ["code"=>"Z014","desc"=>"14 Days Credit"],
                            ["code"=>"Z015","desc"=>"15 Days Credit"],
                            ["code"=>"Z021","desc"=>"21 Days Credit"],
                            ["code"=>"Z030","desc"=>"30 Days Credit"],
                            ["code"=>"Z037","desc"=>"37 Days Credit"],
                            ["code"=>"Z040","desc"=>"40 Days Credit"],
                            ["code"=>"Z045","desc"=>"45 Days Credit"],
                            ["code"=>"Z050","desc"=>"50 Days Credit"],
                            ["code"=>"Z060","desc"=>"60 Days Credit"],
                            ["code"=>"Z075","desc"=>"75 Days Credit"],
                            ["code"=>"Z090","desc"=>"90 Days Credit"],
                            ["code"=>"Z105","desc"=>"105 Days Credit"],
                            ["code"=>"Z0120","desc"=>"120 Days Credit"],
                            ["code"=>"Z150","desc"=>"150 Days Credit"],
                            ["code"=>"ZE30","desc"=>"TT - 30 days after B/L Date"],
                            ["code"=>"ZE37","desc"=>"TT - 37 days after B/L Date"],
                            ["code"=>"ZE60","desc"=>"TT - 60 days after B/L Date"], 	
                            ["code"=>"ZE90", "desc"=>"TT - 90 days from invoice date"]
                        ));
        }
        public static function BpReconAcc(){
            return (array(
                ["GlAcc"=>"1151000003","desc"=>"UM Pembelian Barang SFG"],
                ["GlAcc"=>"1151000004","desc"=>"UM Pembelian Barang spare Part"],
                ["GlAcc"=>"1151000005","desc"=>"UM Pembelian Asset Tetap"],
                ["GlAcc"=>"1151000006","desc"=>"UM Pembelian Bahan Lain"],
                ["GlAcc"=>"1151100000","desc"=>"UM Cukai"],
                ["GlAcc"=>"1151400000","desc"=>"Bon Sementara"],
                ["GlAcc"=>"1151500000","desc"=>"Pengadaan Dana"],
                ["GlAcc"=>"2111000001","desc"=>"Hutang Usaha Pihak Ketiga"],
                ["GlAcc"=>"2112000001","desc"=>"Hutang Usaha Pihak Berelasi"],
                ["GlAcc"=>"2142000001","desc"=>"Hutang Lain Pihak Berelasi"],
                ["GlAcc"=>"2142000002","desc"=>"Hutang Karyawan"],
                ["GlAcc"=>"2142000005","desc"=>"Hutang Cek"]
            ));
            	
            	
           	
            	
            	
            	
            	
            	
            	
            	
            	
            	
            	















        }
        public static function BpSalesDistric(){
            return(array([
                "code"=>"D00001",
                "desc"=>"Jatim Barat"],[
                "code"=>"D00002",
                "desc"=>"Jatim Timur"],[
                "code"=>"D00003",
                "desc"=>"Jateng Utara"],[
                "code"=>"D00004",
                "desc"=>"Jateng Selatan"],[
                "code"=>"D00005",
                "desc"=>"Jabar Utara"],[
                "code"=>"D00006",	
                "desc"=>"Jabar Selatan"],
                ["code"=>"D00007",
                "desc"=>"DKI"],
                ["code"=>"D00008",
                "desc"=>"Banten"],
                ["code"=>"D00009",
                "desc"=>"Bali Nusra"],
                ["code"=>"D00010",
                "desc"=>"Sumatra"],
                ["code"=>"D00011",
                "desc"=>"Kalimantan"],
                ["code"=>"D00012",	
                "desc"=>"Sulawesi Papua"],
                ["code"=>"E00001",	
                "desc"=>"Export"]
            ));
        }

        /*  --- End SAP BP Helper   --  */       
        public static function SAPIndustrySector(){
            return (array("Retail","Plant Engineering / Construction","Chemical Industry", 
                     "Mechanical Engineering","Pharmaceuticals"));
        }

        public static function SAPMaterialType(){
            return (array("ERSA || Sparepart", "FERT || Finished Product"));
        }        

    }
?>