CREATE TABLE vegetables (
  "id" INT8 NOT NULL,
  "name" VARCHAR(256) NOT NULL,
  "classification" VARCHAR(256) NOT NULL,
  "description" TEXT,
  "edible" BOOLEAN NOT NULL DEFAULT true,
  PRIMARY KEY ("id")
) WITH (OIDS=FALSE);

CREATE UNIQUE INDEX "vegetable_id_key" ON "vegetables" USING BTREE ("id" "pg_catalog"."int8_ops");

CREATE SEQUENCE vegetable_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE vegetable_id_seq OWNER TO postgres;

ALTER SEQUENCE vegetable_id_seq OWNED BY vegetables.id;

ALTER TABLE ONLY vegetables ALTER COLUMN id SET DEFAULT nextval('vegetable_id_seq'::REGCLASS);