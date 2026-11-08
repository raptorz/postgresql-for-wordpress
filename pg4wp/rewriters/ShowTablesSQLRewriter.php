<?php

class ShowTablesSQLRewriter extends AbstractSQLRewriter
{
    public function rewrite(): string
    {
        $sql = "SELECT tablename FROM pg_tables WHERE schemaname = 'public'";

        // WordPress uses SHOW TABLES LIKE during installation and schema
        // checks. Preserve the optional pattern when translating the query.
        if(preg_match('/\bLIKE\s+([\'\"])(.*?)\1/i', $this->original(), $matches)) {
            $pattern = str_replace("'", "''", $matches[2]);
            $sql .= " AND tablename LIKE '$pattern'";
        }

        return $sql . ';';
    }
}
