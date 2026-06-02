use raddb_filament;
# Temporarily disable foreign key checks
SET SESSION foreign_key_checks=OFF;

# Migrate the machines table
insert into machines (
    id,manufacturer_id,modality_id,description,model,serial_number,
    vend_site_id,room,install_date,manuf_date,remove_date,machine_status,
    software_version,pacs_station,notes,deleted_at,created_at,updated_at)
select 
    id,manufacturer_id,modality_id,description,model,serial_number,
    vend_site_id,room,install_date,manuf_date,remove_date,machine_status,
    software_version,pacs_station,notes,deleted_at,created_at,updated_at
from raddb.machines;

# Migrate the media table
insert into media (
    id,model_type,model_id,uuid,collection_name,name,file_name,mime_type,
    disk,conversions_disk,size,manipulations,custom_properties,
    generated_conversions,responsive_images,order_column,created_at,
    updated_at
)
select 
    id,model_type,model_id,uuid,collection_name,name,file_name,mime_type,
    disk,conversions_disk,size,manipulations,custom_properties,
    generated_conversions,responsive_images,order_column,created_at,
    updated_at
from raddb.media;

# Migrate the opnotes table
insert into opnotes (
    id,machine_id,note,deleted_at,created_at,updated_at
)
select
    id,machine_id,note,deleted_at,created_at,updated_at
from raddb.opnotes;

# Migrate the testdates table
insert into testdates (
    id,machine_id,testtype_id,test_date,accession,notes,
    deleted_at,created_at,updated_at
)
select
    id,machine_id,type_id,test_date,accession,notes,
    deleted_at,created_at,updated_at
from raddb.testdates;

# Migrate the tubes table
insert into tubes (
    id,machine_id,housing_manuf_id,housing_model,housing_sn,
    insert_manuf_id,insert_model,insert_sn,manuf_date,install_date,
    remove_date,lfs,mfs,sfs,tube_status,notes,deleted_at,created_at,
    updated_at
)
select
    id,machine_id,housing_manuf_id,housing_model,housing_sn,
    insert_manuf_id,insert_model,insert_sn,manuf_date,install_date,
    remove_date,lfs,mfs,sfs,tube_status,notes,deleted_at,created_at,
    updated_at
from raddb.tubes;

# Assign facilities and locations to the machines
# Machines at inactive facilities
update machines set facility_id=1 where id in (
    select id from raddb.machines where raddb.machines.location_id in (
        7,8,18,22,23,24,25,26,27,29,32,34,35,36,37,38,39,40,41,42,43,44,46,47,48,49,56
    )
);
# Medical University Hospital
update machines set facility_id=2 where id in (
    select id from raddb.machines where raddb.machines.location_id in (
        1,2,3,4,5,6,9,11,12,13,15,16,35,44,50,52,62,64
    )
);
update machines set location_id=24 where facility_id=2 and modality_id in (1,3,5,6,18);
update machines set location_id=24 where facility_id=2 and id in (
    select id from raddb.machines where raddb.machines.location_id=9
);

update machines set location_id=26 where facility_id=2 and id in (
    select id from raddb.machines where raddb.machines.location_id=3
);
update machines set location_id=27 where facility_id=2 and modality_id=16;
update machines set location_id=28 where facility_id=2 and modality_id=11;
update machines set location_id=29 where facility_id=2 and id in (
    select id from raddb.machines where raddb.machines.location_id=6
);
update machines set location_id=30 where facility_id=2 and modality_id=10;
update machines set location_id=31 where facility_id=2 and modality_id=7;
update machines set location_id=32 where facility_id=2 and id in (
    select id from raddb.machines where raddb.machines.location_id=15
);

update machines set location_id=34 where facility_id=2 and modality_id=14;
update machines set location_id=36 where facility_id=2 and id in (
    select id from raddb.machines where raddb.machines.location_id=44
);
update machines set location_id=37 where facility_id=2 and modality_id=19;
update machines set location_id=38 where facility_id=2 and modality_id=17;
update machines set location_id=39 where facility_id=2 and modality_id=20;
# Ashley River Tower
update machines set facility_id=3 where id in (
    select id from raddb.machines where raddb.machines.location_id=40
);
update machines set location_id=40 where facility_id=3 and modality_id in (1,3,5,6);
update machines set location_id=41 where facility_id=3 and (room="OR" or room like "ART 4%");
update machines set location_id=42 where facility_id=3 and modality_id=16;
update machines set location_id=43 where facility_id=3 and modality_id=7;
update machines set location_id=44 where facility_id=3 and modality_id=10;
update machines set location_id=45 where facility_id=3 and modality_id=13;
update machines set location_id=46 where facility_id=3 and modality_id=14;
update machines set location_id=47 where facility_id=3 and modality_id=11;
update machines set location_id=48 where facility_id=3 and description like "ART ERCP%";
# SJCH
update machines set facility_id=4 where id in (
    select id from raddb.machines where raddb.machines.location_id=59
);
update machines set location_id=50 where facility_id=4 and modality_id in (1,5);
update machines set location_id=51 where facility_id=4 and modality_id=7;
update machines set location_id=52 where facility_id=4 and modality_id=10;
update machines set location_id=54 where facility_id=4 and modality_id in (2,13);
update machines set location_id=55 where facility_id=4 and modality_id=11;
# Health East
update machines set facility_id=5 where id in (
    select id from raddb.machines where raddb.machines.location_id=51
);
update machines set location_id=56 where facility_id=5 and modality_id in (2,3,18);
update machines set location_id=57 where facility_id=5 and modality_id=7;
update machines set location_id=58 where facility_id=5 and modality_id=10;
update machines set location_id=59 where facility_id=5 and modality_id in (8, 20);

# Health West
update machines set facility_id=6 where id in (
    select id from raddb.machines where raddb.machines.location_id=58
);

# Health North
update machines set facility_id=7 where id in (
    select id from raddb.machines where raddb.machines.location_id=38
);
# Chuck Dawley
update machines set facility_id=8 where id in (
    select id from raddb.machines where raddb.machines.location_id=60
);
# Clements Ferry
update machines set facility_id=9 where id in (
    select id from raddb.machines where raddb.machines.location_id=65
);
# Nexton Medical Park
update machines set facility_id=10 where id in (
    select id from raddb.machines where raddb.machines.location_id=61
);
# Citadel infirmary
update machines set facility_id=11, location_id=80 where id in (
    select id from raddb.machines where raddb.machines.location_id=63
);
# Kiawah Partners
update machines set facility_id=12, location_id=81 where id in (
    select id from raddb.machines where raddb.machines.location_id=66
);
# SMP
update machines set facility_id=13 where id in (
    select id from raddb.machines where raddb.machines.location_id=57 
);
# AHC Summerville
update machines set facility_id=14, location_id=86 where id in (
    select id from raddb.machines where raddb.machines.location_id=54
);
# AHC Mt Pleasant
update machines set facility_id=15, location_id=87 where id in (
    select id from raddb.machines where raddb.machines.location_id=53
);
# AHC Brighton Park
update machines set facility_id=16, location_id=88 where id in (
    select id from raddb.machines where raddb.machines.location_id=67
);
# HCC
update machines set facility_id=19 where id in (
    select id from raddb.machines where raddb.machines.location_id=20
);
update machines set facility_id=19, location_id=99 where id in (
    select id from raddb.machines where raddb.machines.location_id=17
);
update machines set facility_id=19, location_id=100 where id in (285,337,343,486,527);
update machines set facility_id=20, location_id=101 where id in (287,347);
