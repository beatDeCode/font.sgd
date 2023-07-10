select cd_area,cd_ramo_tecnico,cd_moneda,ciudad,sum(polizas) polizas
    from (
    select count(1) polizas,cd_area,ciudad,cd_moneda,cd_ramo_tecnico
        from (
        select 
        cd_area cd_ramo_tecnico,
        case when cd_area=41 then '09' else case when ( cd_area=40) then '01' else case when (cd_area=26) then '26' end end end cd_area,
        decode(cd_ciudad,2,'030000',
        3,'040000',
        4,'050000',
        5,'060000',
        6,'070000',
        7,'080000',
        8,'090000',
        9,'100000',
        1,'020000',
        10,'250000',
        11,'010000',
        12,'110000',
        13,'120000',
        14,'130000',
        15,'140000',
        16,'150000',
        17,'160000',
        18,'170000',
        19,'180000',
        20,'190000',
        21,'200000',
        22,'210000',
        23,'240000',
        24,'220000',
        25,'230000', '010000'
        ) ciudad,
        cd_moneda
        from (
        select 
            pcen.cd_area,
            (select CD_PROVINCIA from SIR.PERSONADIRECCION where cd_persona=pcen.cd_persona
              and nu_consecutivo_direccion = (select max(nu_consecutivo_direccion) from SIR.PERSONADIRECCION where cd_persona=pcen.cd_persona)
            )cd_ciudad,
        (select cd_moneda from sir.poliza where nu_poliza=pcer.nu_poliza) cd_moneda
        from polizacertificado pcer, SIR.POLIZACERTENDOSOBIENGRUPOASEG pcen
        where pcer.CD_AREA = pcen.CD_AREA
        and pcer.CD_ENTIDAD = pcen.CD_ENTIDAD
        and pcer.NU_CERTIFICADO = pcen.NU_CERTIFICADO
        and pcer.NU_POLIZA = pcen.NU_POLIZA
        and pcer.NU_ULTIMO_ENDOSO=pcen.nu_endoso
        and st_certificado=1
        and pcen.cd_Area=41
        and pcer.fe_desde between :fe_a and :fe_b
        )
    ) group by ciudad, cd_area,cd_moneda,cd_ramo_tecnico
    
)group by ciudad, cd_area,cd_moneda,cd_ramo_tecnico
union all
select cd_area,cd_ramo_tecnico,cd_moneda,ciudad,sum(polizas) polizas
    from (
    select count(1) polizas,cd_area,ciudad,cd_moneda,cd_ramo_tecnico
        from (
        select 
        cd_area cd_ramo_tecnico,
        case when cd_area=41 then '09' else case when ( cd_area=40) then '01' else case when (cd_area=26) then '26' end end end cd_area,
        decode(cd_ciudad,2,'030000',
        3,'040000',
        4,'050000',
        5,'060000',
        6,'070000',
        7,'080000',
        8,'090000',
        9,'100000',
        1,'020000',
        10,'250000',
        11,'010000',
        12,'110000',
        13,'120000',
        14,'130000',
        15,'140000',
        16,'150000',
        17,'160000',
        18,'170000',
        19,'180000',
        20,'190000',
        21,'200000',
        22,'210000',
        23,'240000',
        24,'220000',
        25,'230000', '010000'
        ) ciudad,
        cd_moneda
        from (
        select 
            pcen.cd_area,
            (select CD_PROVINCIA from SIR.PERSONADIRECCION where cd_persona=pcen.cd_persona_asegurada
              and nu_consecutivo_direccion = (select max(nu_consecutivo_direccion) from SIR.PERSONADIRECCION where cd_persona=pcen.cd_persona_asegurada)
            )cd_ciudad,
        (select cd_moneda from sir.poliza where nu_poliza=pcer.nu_poliza) cd_moneda
        from polizacertificado pcer, polizacertificadoendoso pcen
        where pcer.CD_AREA = pcen.CD_AREA
        and pcer.CD_ENTIDAD = pcen.CD_ENTIDAD
        and pcer.NU_CERTIFICADO = pcen.NU_CERTIFICADO
        and pcer.NU_POLIZA = pcen.NU_POLIZA
        and pcer.NU_ULTIMO_ENDOSO=pcen.nu_endoso
        and st_certificado=1
        and pcer.cd_area in (40,26)
        and pcer.fe_desde between :fe_a and :fe_b
        
        )
    ) group by ciudad, cd_area,cd_moneda,cd_ramo_tecnico
)group by ciudad, cd_area,cd_moneda,cd_ramo_tecnico
order by cd_area,ciudad