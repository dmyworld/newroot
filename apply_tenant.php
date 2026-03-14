<?php
$f = file_get_contents('application/models/Transactions_model.php'); 
$search1 = "if (\$this->aauth->get_user()->loc) {\n            \$this->db->where('loc', \$this->aauth->get_user()->loc);\n        }";
$search2 = "if (\$this->aauth->get_user()->loc) {\r\n            \$this->db->where('loc', \$this->aauth->get_user()->loc);\r\n        }";
$replace = "if (\$this->aauth->get_user()->business_id) {\n            \$this->db->where('geopos_transactions.business_id', \$this->aauth->get_user()->business_id);\n        }\n        if (\$this->aauth->get_user()->loc) {\n            \$this->db->where('geopos_transactions.loc', \$this->aauth->get_user()->loc);\n        }";

$f = str_replace($search1, $replace, $f);
$f = str_replace($search2, $replace, $f);

// Also handle the `if (!$loc) $loc = $this->aauth->get_user()->loc;` but wait, loc is param.
// What about `$this->db->where('loc', $this->aauth->get_user()->loc);` with different spacing?
$f = preg_replace(
    '/(if \(\$this->aauth->get_user\(\)->loc\)\s*\{\s*\$this->db->where\(\'loc\', \$this->aauth->get_user\(\)->loc\);\s*})/',
    "if (\$this->aauth->get_user()->business_id) {\n            \$this->db->where('geopos_transactions.business_id', \$this->aauth->get_user()->business_id);\n        }\n        $1",
    $f
);

file_put_contents('application/models/Transactions_model.php', $f);
echo "Replaced in Transactions_model.php";

// Let's also do Products_model.php
$p = file_get_contents('application/models/Products_model.php');
$p = preg_replace(
    '/(if \(\$this->aauth->get_user\(\)->loc\)\s*\{\s*\$this->db->where\(\'(geopos_products\.)?loc\', \$this->aauth->get_user\(\)->loc\);\s*})/',
    "if (\$this->aauth->get_user()->business_id) {\n            \$this->db->where('geopos_products.business_id', \$this->aauth->get_user()->business_id);\n        }\n        $1",
    $p
);
file_put_contents('application/models/Products_model.php', $p);
echo " and Products_model.php\n";

