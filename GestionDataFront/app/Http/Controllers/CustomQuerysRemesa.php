<?php

namespace App\Http\Controllers;


class CustomQuerysRemesa{
    const vDataOptima=	    
		"select 
		    sum(valores)ca_registros,
		    'Entre '||
		        case when min_edad is null then 'Sin Rango.' else
		        (select min_edad 
		            from 
		            corereporteedad reed
		            where
		            reed.cd_rango_edad=a2.cd_rango_edad
		            )||' y '||
		            (select max_edad 
		            from 
		            corereporteedad reed
		            where
		            reed.cd_rango_edad=a2.cd_rango_edad
		            )
		        end de_rango,
		        nvl(cd_rango_edad,0)cd_rango,
		        case when sum(valores)=0 then 0 else round( ( (sum(valores)*100)/sum(data_entera)),2)end||'%' po_registros,
		  	    'S/A' po_comercial

					from (
					select 
					    (select min_edad 
					            from 
					            corereporteedad reed
					            where
					            reed.cd_rango_edad=a2.cd_rango_edad
					            ) min_edad, 
					    (select max_edad 
					            from 
					            corereporteedad reed
					            where
					            reed.cd_rango_edad=a2.cd_rango_edad
					    )max_edad,
					    cd_rango_edad,
					    data_entera,
					    sum(valores) valores 
					from( 
					    select 
					    data_entera,
					    count(1) valores,
					    cd_rango_edad 
					    from 
					    ( 
					        select 
					            (select cd_rango_edad 
					            from 
					            corereporteedad 
					            where trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12) between min_edad and max_edad 
					            and cd_aliado=:cd_aliado
					            ) cd_rango_edad,
					            (select count(1)  
					                            from coregestionremesa core1 
					                            where core1.cd_remesa=core2.cd_remesa 
					                            and st_gestion_remesa=:st_gestion_remesa and   
					                            in_validaprimernombre=1 and                               
					                            in_validaprimerapellido=1 and   
					                            in_validanudocumento=1 and   
					                            in_valida_correo=1 and   
					                            in_valida_telefono_movil=1 and   
					                            in_valida_telefono_local=1 and   
					                            in_valida_fecha_nacimiento=1 and   
					                            in_duplicado is null ) data_entera 
					        from coregestionremesa core2 
					        where cd_remesa=:cd_remesa and 
					        in_validaprimernombre=1 and                             
					        in_validaprimerapellido=1 and 
					        in_validanudocumento=1 and 
					        in_valida_correo=1 and 
					        in_valida_telefono_movil=1 and 
					        in_valida_telefono_local=1 and 
					        in_valida_fecha_nacimiento=1 and 
					        in_duplicado is null and 
							 st_gestion_remesa=:st_gestion_remesa
					    ) a1
					    group by cd_rango_edad,data_entera
					)a2
					group by cd_rango_edad,data_entera

					union all
					select 
					    min_edad,max_edad,cd_rango_edad,0 data_entera,0 valores
					from COREREPORTEEDAD
					where cd_aliado=:cd_aliado
					)a2
					group by max_edad, min_edad,cd_rango_edad
					order by min_edad";
	const vDataNoOptima=
	"select 
		sum (cuenta) ca_registros, titulo de_titulo,cd_data_no_optima 
		from (    
		 select  
		 sum(cuenta) cuenta,
		 titulo,
		 cd_data_no_optima ,
		 cd_orden_motivo
		 from ( 

		     select   
		     count(1) cuenta,
		     titulo,
		     cd_data_no_optima ,
		     cd_orden_motivo
		     from (  
		         select   
		         (select tx_titulo from COREREPORTEDATANOOPTIMA where in_valida_correo=correo
		         and in_valida_telefono=telefono and in_valida_fe_nacimiento=fe_nacimiento  )  titulo,
		         (select cd_data_no_optima from COREREPORTEDATANOOPTIMA where in_valida_correo=correo
		         and in_valida_telefono=telefono and in_valida_fe_nacimiento=fe_nacimiento  )  cd_data_no_optima,
		         (select cd_orden_motivo from COREREPORTEDATANOOPTIMA where in_valida_correo=correo
		         and in_valida_telefono=telefono and in_valida_fe_nacimiento=fe_nacimiento  )  cd_orden_motivo
		         from(  
		             select   
		             case when tx_correo is null then 0 else 1 end correo,  
		             case when nu_telefono is null   
		             then 0   
		             else  
		             case when length(nu_telefono)=10   
		             then   
		             case when substr(nu_telefono,1,3) in ('424','412','414','416','426') then 1 else 0 end  
		             else 0   
		             end  
		             end telefono,  
		             case when abs(nvl(to_number(replace(nu_edad,'.0','')),0)-trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12))<=2 then 1 else 0 end  fe_nacimiento  

		             from coregestionremesa core  
		             where core.cd_remesa=:cd_remesa and  
		             in_validaprimernombre=0 and  
		             in_validaprimerapellido=0 and  
		             in_validanudocumento=0 and  
		             in_valida_correo=0 and  
		             in_valida_telefono_movil=0 and  
		             in_valida_telefono_local=0 and  
		             in_valida_fecha_nacimiento=0  
		             and in_duplicado is null 
		         )
		         -- 
		     ) 
		     group by
		     titulo,
		     cd_data_no_optima,cd_orden_motivo
		     --
		 ) group by titulo,
		 cd_data_no_optima,cd_orden_motivo
		 union all
		 select 0 cuenta, tx_titulo, cd_data_no_optima,cd_orden_motivo from COREREPORTEDATANOOPTIMA
		 union all
		 select count(1) cuenta, 'Data Duplicada en sistema' titulo, 'I' cd_data_no_optima, 9 cd_orden_motivo from coregestionremesa
		 where cd_remesa=:cd_remesa 
		 and in_duplicado=1
		)group by titulo,cd_data_no_optima,cd_orden_motivo
		order by cd_orden_motivo asc";

	const vListaRemesas=
		"select cd_remesa value, 'Remesa # '||nu_consecutivo_remesa||', Aliado: '|| 
			(select de_dato from tablainformacion where cd_tabla=410094 and va_dato1=core.cd_aliado)||', Producto: '||
		    (select initcap(de_producto) from producto where cd_producto=core.cd_producto) text from coreremesa core
		where st_remesa>=3
		order by cd_Remesa desc";
	const vListaRemesasParaCampanias=
		"select cd_remesa value, 'Remesa # '||nu_consecutivo_remesa||', Aliado: '|| 
			(select de_dato from tablainformacion where cd_tabla=410094 and va_dato1=core.cd_aliado)||', Producto: '||
		    (select initcap(de_producto) from producto where cd_producto=core.cd_producto) text from coreremesa core
		where st_remesa>=3
		and (select count(1) from coregestionremesa where cd_remesa=core.cd_remesa and cd_campania is not null)>0
		order by cd_Remesa desc";
	const vDetalleRemesa="select nu_consecutivo_remesa||'^Código de la remesa|'||
			(select de_dato from tablainformacion where cd_tabla=410094 and va_dato1=core.cd_aliado)||'^Aliado Comercial|'||
		    (select initcap(de_producto) from producto where cd_producto=core.cd_producto)||'^Producto|'||
		    fe_remesa||'^Fecha de la remesa|'||
		    nm_remesa||'^Nombre de la remesa|'||
		    nu_registros_cargados||'^Registros Cargados' text, cd_aliado value from coreremesa core
		where st_remesa>=3
		and cd_remesa=:cd_remesa
		order by cd_Remesa desc";

	const VProcesosTecnicos="
		select 
			(select count(1) from coregestionremesa core where core.cd_proceso_tecnico=proc.cd_proceso_tecnico) ca_registros,
			'Entre '||min_edad||' y '||max_edad de_rango,
			po_descuento,
			round((
			(select count(1) from coregestionremesa core where core.cd_proceso_tecnico=proc.cd_proceso_tecnico)/
			(select count(1) from coregestionremesa core where cd_remesa=proc.cd_remesa and st_gestion_remesa in (4,5)))*100,2) po_registros,
			proc.in_solicitud_seguros,
			proc.in_emision_masiva,
			proc.in_envio_cuadro_poliza,
			proc.in_solicitud_campania,
			to_char(trunc(fe_proceso),'dd/mm/yyyy') fe_proceso,
			cd_proceso_tecnico ,
			(
				select de_dato text
				from tablainformacion 
				where cd_tabla=410001
				and fe_termino_informacion is null
				and va_dato1=1 and va_Dato2=504
				and va_dato3=proc.mt_suma_asegurada
			) mt_suma_asegurada
		 from coreprocesotecnico proc
		 where cd_remesa=:cd_remesa";

	const vPorcetajesDataOptimaPorRangoEdad=
	"select 
	edad de_rango_edad ,valor ca_registros,
	'<b>'||round(valor*100/
	(SELECT 
		count(1) valor
		FROM COREGESTIONREMESA 
		where cd_remesa=:cd_remesa
		and in_validaprimernombre=1 and 
		in_validaprimerapellido=1 and 
		in_validanudocumento=1 and 
		in_valida_correo=1 and 
		in_valida_telefono_movil=1 and 
		in_valida_telefono_local=1 and 
		in_valida_fecha_nacimiento=1 and 
		in_duplicado is null
		and trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD-MM-YYYY'))/12) between 
		(select min_edad from corereporteedad where cd_rango_edad=:cd_rango) and 
		(select max_edad from corereporteedad where cd_rango_edad=:cd_rango)
	),2)||' %</b>' po_registros 
	from 
		(
			SELECT 
			count(1) valor,trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)edad
			FROM COREGESTIONREMESA 
			where cd_remesa=:cd_remesa
			and st_gestion_remesa=3 
				and in_validaprimernombre=1 and 
			in_validaprimerapellido=1 and 
			in_validanudocumento=1 and 
			in_valida_correo=1 and 
			in_valida_telefono_movil=1 and 
			in_valida_telefono_local=1 and 
			in_valida_fecha_nacimiento=1 and 
			in_duplicado is null
			and trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD-MM-YYYY'))/12) between 
			(select min_edad from corereporteedad where cd_rango_edad=:cd_rango) and 
			(select max_edad from corereporteedad where cd_rango_edad=:cd_rango)
			group  by trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)
		)
	order by edad";
	const vPorcentajesDataGlobal="
		select 
		edad de_rango_edad ,valor ca_registros,
		'<b>'||round(valor*100/
		(
		select sum(valor)valor
		from (
			SELECT 
			
			count(1) valor,trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)edad
			FROM COREGESTIONREMESA 
			where cd_remesa=:cd_remesa
			--an  st_gestion_remesa=3 
			
			group  by trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)
		)
		
		),2)||' %</b>' po_registros 
	from 
	(
		select sum(valor)valor, edad
		from (
		SELECT 
		
		count(1) valor,trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)edad
		FROM COREGESTIONREMESA 
		where cd_remesa=:cd_remesa 
		
		group  by trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)
		
		)group by edad
	)
	order by edad
	";

	const vPorcentajesDataOptima="
	select 
	edad de_rango_Edad,valor ca_registros,
	'<b>'||round(valor*100/
	(
	select sum(valor)valor
	from (
		SELECT 
		
		count(1) valor,trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)edad
		FROM COREGESTIONREMESA 
		where cd_remesa=:cd_remesa
		--an  st_gestion_remesa=3 
			and in_validaprimernombre=1 and 
		in_validaprimerapellido=1 and 
		in_validanudocumento=1 and 
		in_valida_correo=1 and 
		in_valida_telefono_movil=1 and 
		in_valida_telefono_local=1 and 
		in_valida_fecha_nacimiento=1 and 
		in_duplicado is null
		group  by trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)
		
	)
	
	),2)||' %</b>' po_registros 
	from 
	(
		select sum(valor)valor, edad
		from (
		SELECT 
		
		count(1) valor,trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)edad
		FROM COREGESTIONREMESA 
		where cd_remesa=:cd_remesa
		--an  st_gestion_remesa=3 
			and in_validaprimernombre=1 and 
		in_validaprimerapellido=1 and 
		in_validanudocumento=1 and 
		in_valida_correo=1 and 
		in_valida_telefono_movil=1 and 
		in_valida_telefono_local=1 and 
		in_valida_fecha_nacimiento=1 and 
		in_duplicado is null
		group  by trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)
		
		)group by edad
	)
	order by edad";

	const vPorcentajesDataNoOptima="
		select 
		edad de_rango_edad ,valor ca_registros,
		'<b>'||round(valor*100/
		(
		select sum(valor)valor
		from (
			SELECT 
			
			count(1) valor,trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)edad
			FROM COREGESTIONREMESA 
			where cd_remesa=:cd_remesa
			--an  st_gestion_remesa=3 
				and in_validaprimernombre=0 and 
			in_validaprimerapellido=0 and 
			in_validanudocumento=0 and 
			in_valida_correo=0 and 
			in_valida_telefono_movil=0 and 
			in_valida_telefono_local=0 and 
			in_valida_fecha_nacimiento=0 and 
			in_duplicado is null
			group  by trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)
			union all
			SELECT 
			count(1) valor,trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)edad
			FROM COREGESTIONREMESA 
			where cd_remesa=:cd_remesa
			--an  st_gestion_remesa=3 
				
			and in_duplicado=1
			group  by trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)
		)
		
		),2)||' %</b>' po_registros 
	from 
	(
		select sum(valor)valor, edad
		from (
		SELECT 
		
		count(1) valor,trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)edad
		FROM COREGESTIONREMESA 
		where cd_remesa=:cd_remesa
		--an  st_gestion_remesa=3 
			and in_validaprimernombre=0 and 
		in_validaprimerapellido=0 and 
		in_validanudocumento=0 and 
		in_valida_correo=0 and 
		in_valida_telefono_movil=0 and 
		in_valida_telefono_local=0 and 
		in_valida_fecha_nacimiento=0 and 
		in_duplicado is null
		group  by trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)
		union all
		SELECT 
		count(1) valor,trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12)edad
		FROM COREGESTIONREMESA 
		where cd_remesa=:cd_remesa
		--an  st_gestion_remesa=3 
			
		and in_duplicado=1
		group  by trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12) 
		)group by edad
	)
	order by edad";

	const vActualizarRemesaAProcesoTecnico="
	update COREGESTIONREMESA core 
	set core.ST_GESTION_REMESA=:st_remesa, 
	core.cd_proceso_tecnico=:cd_proceso_tecnico, 
	core.mt_suma_asegurada=:mt_suma_asegurada, 
	po_descuento_gestion=:po_comercial 
		where cd_gestion_remesa in ( 
		SELECT  
			CD_GESTION_REMESA  
		FROM COREGESTIONREMESA  
			where cd_remesa=:cd_remesa 
			and in_validaprimernombre=1 and  
			in_validaprimerapellido=1 and  
			in_validanudocumento=1 and  
			in_valida_correo=1 and  
			in_valida_telefono_movil=1 and  
			in_valida_telefono_local=1 and  
			in_valida_fecha_nacimiento=1 and  
			in_duplicado is null 
			and trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD-MM-YYYY'))/12) between  
			(select min_edad from corereporteedad where CD_RANGO_EDAD=:cd_rango_edad) and  
			(select max_edad from corereporteedad where CD_RANGO_EDAD=:cd_rango_edad)
			and st_gestion_remesa=3 
		and rownum <=:ca_registros
		)";

	const vSumasAseguradas="
		select va_dato3 value,de_dato text,'Suma Asegurada' title, 12 col ,'mt_suma_asegurada' name
		from tablainformacion 
		where cd_tabla=410001
		and fe_termino_informacion is null
		and va_dato1=1 and va_Dato2=504
		and de_dato like '%TCH %'
		order by de_dato asc";
	const vPorcentajesComerciales="select va_dato2 value,de_dato text,'Porcentaje Comercial' title, 12 col,'po_comercial' name  
	from tablainformacion where cd_tabla=410092 and fe_termino_informacion is null and in_suspendido=0 
	--and de_indice_dato like '%1|%' 
	order by va_dato2 asc";
	
	const vListasDeNombresCompuestos='select nombre_crudo,cd_gestion_remesa from 
			coregestionremesa 
			where cd_remesa=:cd_remesa
			and  cd_usuario_actualizador=:cd_usuario
			and nm_nombre1 is null 
			and nm_apellido1 is null 
			and in_actualizacion_nombre=1
			and rownum<=7';
	const vListaDeRemesasConNombresCompuestos=
		"select value,text from (
			select  sum(cuenta) cuenta ,
			cd_remesa value, 'Remesa # '||(select nu_consecutivo_remesa from coreremesa where cd_remesa=a1.cd_remesa)||', Aliado: '|| 
					(select de_dato from tablainformacion where cd_tabla=410094 and va_dato1=(select cd_aliado from coreremesa where cd_remesa=a1.cd_remesa))||', Producto: '||
					(select initcap(de_producto) from producto where cd_producto=(select cd_producto from coreremesa where cd_remesa=a1.cd_remesa)) text
			 from (
				select 
				count(1) cuenta,
				case when tx_correo is null then 0 else 1 end correo,  
				case when nu_telefono is null   
				then 0   
				else  
				case when length(nu_telefono)=10   
				then   
				case when substr(nu_telefono,1,3) in ('424','412','414','416','426') then 1 else 0 end  
				else 0   
				end  
				end telefono,  
				cd_remesa,
				case when abs(nvl(to_number(replace(nu_edad,'.0','')),0)-trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12))<=2 then 1 else 0 end  fe_nacimiento  
				from coregestionremesa 
				where nm_apellido1 is null and nm_nombre1 is null 
				and nvl(in_actualizacion_nombre,0) in (0,1)
				group by tx_correo,nu_telefono,nu_edad,fe_nacimiento,cd_remesa
			)a1
			--where correo=1 and telefono=1 and fe_nacimiento=1
			group by cd_remesa)
		where cuenta>0";
		/*"

		select  cd_remesa value, 'Remesa # '||nu_consecutivo_remesa||', Aliado: '|| 
		(select de_dato from tablainformacion where cd_tabla=410094 and va_dato1=core.cd_aliado)||', Producto: '||
		(select initcap(de_producto) from producto where cd_producto=core.cd_producto) text
		from coreremesa core
		where 
		st_validacion_nombre=0
	"*/

	const vActualizarListaDeRemesasConNombresCompuestos="
		update coregestionremesa 
		set cd_usuario_actualizador=:cd_usuario , in_actualizacion_nombre=1
		where cd_gestion_remesa in (
			select cd_gestion_remesa from (
				select 
					cd_gestion_remesa ,
					case when tx_correo is null then 0 else 1 end correo,  
					case when nu_telefono is null   
					then 0   
					else  
					case when length(nu_telefono)=10   
					then   
					case when substr(nu_telefono,1,3) in ('424','412','414','416','426') then 1 else 0 end  
					else 0   
					end  
					end telefono ,
					case when abs(nvl(to_number(replace(nu_edad,'.0','')),0)-trunc(months_between(trunc(sysdate),to_date(fe_nacimiento,'DD/MM/YYYY'))/12))<=2 then 1 else 0 end  fe_nacimiento  
					
				from 
				coregestionremesa where cd_remesa=:cd_remesa 
				and nm_nombre1 is null 
				and nm_apellido1 is null 
				and in_actualizacion_nombre is null
				and (select count(1) from coregestionremesa where cd_usuario_actualizador=:cd_usuario and in_actualizacion_nombre=1 and cd_remesa=:cd_remesa )<1
				group by tx_correo,nu_telefono,nu_edad,fe_nacimiento,cd_gestion_remesa
			)where correo=1 and telefono=1 and fe_nacimiento=1
			and rownum<=7				
		)
	";
	const vActualizarProcesoTecnico='
	update coreprocesotecnico 
		set :tx_campo=:in_valor
	where cd_proceso_tecnico=:cd_proceso_tecnico';

	const vActualizarGestionRemesaDeProcesoTecnico='
	update coregestionremesa 
		set :tx_campo=:in_valor,st_gestion_remesa=4
	where cd_proceso_tecnico=:cd_proceso_tecnico';

	const vListaAliadoYProductoDelProcesotecnico='select 
	(select cd_aliado from coreremesa where cd_remesa=core.cd_remesa)cd_aliado,
	(select cd_producto from coreremesa where cd_remesa=core.cd_remesa)cd_producto
	from coreprocesotecnico core
	where cd_proceso_tecnico=:cd_proceso_tecnico';

	const vActualizarRegistrosDeLaCampania='
		update coregestionremesa
		set cd_campania=:cd_campania 
		where cd_proceso_tecnico=:cd_proceso_tecnico';

	const vActualizarRemesaParaProcesosTecnicoDeCampania='
		update coregestionremesa
		set cd_proceso_campania=:cd_proceso_campania 
		where cd_campania=:cd_campania';

	const vListaDeCampanias="
		select cd_campania||'-'||cd_proceso_tecnico value, 
		'Remesa #'||(select nu_consecutivo_remesa from coreremesa where cd_remesa 
			in (select cd_remesa from coreprocesotecnico where cd_proceso_tecnico=core.cd_proceso_tecnico)
		)||'-'||tx_campania text from corecampania core
		where st_campania=1 
		and cd_proceso_tecnico in (select cd_proceso_tecnico from coreprocesotecnico where cd_remesa=:cd_remesa)

		order by cd_campania desc
	";
	const vPanelEstadisticoPorUsuario="
	select sum(1) ca_registros, cd_variable, tx_variable,nm_usuario,
		round(
		(sum(1)*100)/
		(select count (cd_gestion_remesa) 
		from (
		    (select max(nu_consecutivo) nu_consecutivo, count(1),cd_gestion_remesa 
		    from coregestioncampania where cd_campania=:cd_campania and cd_usuario=a2.cd_usuario
		    and cd_variable1 not in  (select cd_valor from coreparametros where cd_tabla =('CC_VARIABLE_NC')  )
		    group by cd_gestion_remesa)
		)),2) po_efectividad,
		(select count (cd_gestion_remesa) 
		from (
		    (select max(nu_consecutivo) nu_consecutivo, count(1),cd_gestion_remesa 
		    from coregestioncampania where cd_campania=:cd_campania and cd_usuario=a2.cd_usuario
		    and cd_variable1 not in  (select cd_valor from coreparametros where cd_tabla =('CC_VARIABLE_NC')  )
		    group by cd_gestion_remesa)
		)) cantidad_llamadas
		from(
			select  
				(select tx_variable from corevariablescallcenter where cd_variable=
					(select cd_variable1 from coregestioncampania where cd_gestion_campania=a1.cd_gestion_campania)) tx_variable,
					(select cd_variable1 from coregestioncampania where cd_gestion_campania=a1.cd_gestion_campania) cd_variable,
				(select nm_usuario from coreusuario where cd_usuario=(select cd_usuario from coregestioncampania where cd_gestion_campania=a1.cd_gestion_campania))nm_usuario,
				(select cd_usuario from coregestioncampania where cd_gestion_campania=a1.cd_gestion_campania) cd_usuario
				
			from (
				select max(nu_consecutivo)nu_consecutivo,max(cd_gestion_campania)cd_gestion_campania,cd_gestion_remesa 
				from coregestioncampania
				where cd_campania=:cd_campania
				and cd_variable1=:cd_variable
				group by cd_gestion_remesa
			)a1
		)a2
		group by cd_variable, tx_variable,nm_usuario,cd_usuario";

	const vPanelEstadisticoPorNumeroContacto="
	select sum(ca_registros) ca_registros,cd_variable, tx_variable
	from (
		select sum(1)ca_registros, cd_variable, tx_variable
		from(
			select  
				(select tx_variable from corevariablescallcenter where cd_variable=
				(select cd_variable1 from coregestioncampania where cd_gestion_campania=a1.cd_gestion_campania)) tx_variable,
				(select cd_variable1 from coregestioncampania where cd_gestion_campania=a1.cd_gestion_campania) cd_variable,
				(select nm_usuario from coreusuario where cd_usuario=(select cd_usuario from coregestioncampania where cd_gestion_campania=a1.cd_gestion_campania))nm_usuario
			from (
				select --max(nu_consecutivo)
				nu_consecutivo,
				--max(cd_gestion_campania)
				cd_gestion_campania,cd_gestion_remesa 
				from coregestioncampania
				where cd_campania=:cd_campania
				and nu_consecutivo=:nu_consecutivo
				--group by cd_gestion_remesa
			)a1
			--where 
		)
		group by cd_variable, tx_variable,nm_usuario
		union all
		select 
		count(core.cd_gestion_remesa) ca_registros,
		0 cd_variable,
		'Sin Gestionar' tx_variable
		from coregestionremesa core
		where   core.cd_campania=:cd_campania
		and core.cd_gestion_remesa not in (
			select cd_gestion_remesa from coregestioncampania where cd_campania=:cd_campania
			--and nu_consecutivo=:nu_consecutivo
		)
		group by core.cd_campania
	)where cd_variable not in (case when :nu_consecutivo>=(select nu_consecutivo from corecampania where cd_campania=:cd_campania) then 9999999999 else 0 end) 
	group by cd_variable, tx_variable
	";	
	const vPanelGeneralEstadisticoCampanias="
		select
		ca_registros,
		cd_variable,
		tx_variable,
		case when ca_registros>0 
			then round((ca_registros*100)/ (select count(1) from coregestionremesa where cd_campania=a3.cd_campania),2)
			else 0
		end ||'%' po_registros,
		case when ca_registros>0 
			then round((ca_registros*100)/ (select count(1) from coregestionremesa where cd_campania=a3.cd_campania),2)
			else 0
		end po_numerico,
		nvl((select in_decision_final from corevariablescallcenter where cd_variable=a3.cd_variable ),0) in_decision_final
		from(
			select  
			a2.cd_variable,
			a2.tx_variable,
			a2.cd_campania,
			sum(a2.ca_registros)ca_registros
			from (
				select  
					count(1) ca_registros,
					(select 
						(select tx_variable from corevariablescallcenter where cd_variable=coca.cd_variable1) 
					from coregestioncampania coca where cd_gestion_campania=a1.cd_gestion_campania)tx_variable,
					(select coca.cd_variable1 
					from coregestioncampania coca where cd_gestion_campania=a1.cd_gestion_campania)cd_variable,
					a1.cd_campania
					
				from (
				select 
				max(cd_gestion_campania) cd_gestion_campania,
				core.cd_gestion_remesa,
				camp.cd_campania
				from coregestionremesa core,coregestioncampania camp
				where core.cd_proceso_tecnico=:cd_proceso_tecnico
				and core.cd_campania=:cd_campania
				and core.cd_gestion_remesa=camp.cd_gestion_remesa
				and core.cd_campania=camp.cd_campania
				group by core.cd_gestion_remesa,camp.cd_campania
				)a1
				group by a1.cd_gestion_campania,a1.cd_campania
				union all
				select 
				count(core.cd_gestion_remesa) ca_registros,
				'Sin Gestionar' tx_variable,
				0 cd_variable,
				core.cd_campania
				from coregestionremesa core
				where  core.cd_proceso_tecnico=:cd_proceso_tecnico
				and core.cd_campania=:cd_campania
				and core.cd_gestion_remesa not in (
					select cd_gestion_remesa from coregestioncampania where cd_campania=:cd_campania
				)
				group by core.cd_campania
			)a2
			group by a2.cd_variable,
			a2.tx_variable,
			a2.cd_campania
		)a3
		order by tx_variable
	";	
	const vPanelGeneralEstadisticoVariable0="
		select
		ca_registros,
		cd_variable,
		tx_variable,
		case when ca_registros>0 
			then round((ca_registros*100)/ (select count(1) from coregestionremesa where cd_campania=a3.cd_campania),2)
			else 0
		end ||'%' po_registros,
		case when ca_registros>0 
			then round((ca_registros*100)/ (select count(1) from coregestionremesa where cd_campania=a3.cd_campania),2)
			else 0
		end po_numerico,
		nvl((select in_decision_final from corevariablescallcenter where cd_variable=a3.cd_variable ),0) in_decision_final
		from(
			select  
			a2.cd_variable,
			a2.tx_variable,
			a2.cd_campania,
			sum(a2.ca_registros)ca_registros
			from (
				select  
					count(1) ca_registros,
					(select 
						(select tx_variable from corevariablescallcenter where cd_variable=coca.cd_variable0) 
					from coregestioncampania coca where cd_gestion_campania=a1.cd_gestion_campania)tx_variable,
					(select coca.cd_variable0 
					from coregestioncampania coca where cd_gestion_campania=a1.cd_gestion_campania)cd_variable,
					a1.cd_campania
					
				from (
				select 
				max(cd_gestion_campania) cd_gestion_campania,
				core.cd_gestion_remesa,
				camp.cd_campania
				from coregestionremesa core,coregestioncampania camp
				where core.cd_proceso_tecnico=:cd_proceso_tecnico
				and core.cd_campania=:cd_campania
				and core.cd_gestion_remesa=camp.cd_gestion_remesa
				and core.cd_campania=camp.cd_campania
				group by core.cd_gestion_remesa,camp.cd_campania
				)a1
				group by a1.cd_gestion_campania,a1.cd_campania
				union all
				select 
				count(core.cd_gestion_remesa) ca_registros,
				'Sin Gestionar' tx_variable,
				0 cd_variable,
				core.cd_campania
				from coregestionremesa core
				where  core.cd_proceso_tecnico=:cd_proceso_tecnico
				and core.cd_campania=:cd_campania
				and core.cd_gestion_remesa not in (
					select cd_gestion_remesa from coregestioncampania where cd_campania=:cd_campania
				)
				group by core.cd_campania
			)a2
			group by a2.cd_variable,
			a2.tx_variable,
			a2.cd_campania
		)a3
		order by tx_variable
	";
	const vPanelPorIntentos="
	select 
		sum(ca_registros_int_0)ca_registros_int_0,
		sum(ca_registros_int_1)ca_registros_int_1,
		sum(ca_registros_int_2)ca_registros_int_2,
		sum(ca_registros_int_3)ca_registros_int_3,
		sum(ca_registros_int_4)ca_registros_int_4,
		tx_variable,
		cd_variable,
		cd_campania
		from (
			select 
			0 ca_registros_int_0,
			case when nu_intento=1 
				then sum(ca_registros)
				else 0
			end ca_registros_int_1,
			case when nu_intento=2 
				then sum(ca_registros)
				else 0
			end ca_registros_int_2,
			case when nu_intento=3
				then sum(ca_registros)
				else 0
			end ca_registros_int_3,
			case when nu_intento=4 
				then sum(ca_registros)
				else 0
			end ca_registros_int_4,
			tx_variable,
			cd_variable,
			cd_campania
			from (
				select sum(ca_registros) ca_registros,
					tx_variable,
					cd_variable,
					nu_intento,
					cd_campania
				from (
					select  
						count(1) ca_registros,
						(select 
							(select tx_variable from corevariablescallcenter where cd_variable=coca.cd_variable0) 
						from coregestioncampania coca where cd_gestion_campania=a1.cd_gestion_campania)tx_variable,
						(select coca.cd_variable0
						from coregestioncampania coca where cd_gestion_campania=a1.cd_gestion_campania)cd_variable,
						a1.cd_campania,
						nu_intento
					from (
					select 
					max(cd_gestion_campania) cd_gestion_campania,
					count(1) nu_intento,
					core.cd_gestion_remesa,
					camp.cd_campania
					from coregestionremesa core,coregestioncampania camp
					where core.cd_proceso_tecnico=:cd_proceso_tecnico
					and core.cd_campania=:cd_campania
					and core.cd_gestion_remesa=camp.cd_gestion_remesa
					and core.cd_campania=camp.cd_campania
					group by core.cd_gestion_remesa,camp.cd_campania
					)a1
					group by a1.cd_gestion_campania,a1.cd_campania,nu_intento
				) group by
				tx_variable,
				cd_variable,
				nu_intento,
				cd_campania
			)group by 
			tx_variable,
			cd_variable,
			cd_campania,
			nu_intento
			union all
			select 
			count(1)ca_registros_int_0,
			0 ca_registros_int_1,
			0 ca_registros_int_2,
			0 ca_registros_int_3,
			0 ca_registros_int_4,
			'Sin gestionar' tx_variable,
			0 cd_variable,
			cd_campania
			from coregestionremesa core
			where  core.cd_proceso_tecnico=:cd_proceso_tecnico
			and core.cd_campania=:cd_campania
			and core.cd_gestion_remesa not in (
				select cd_gestion_remesa from coregestioncampania where cd_campania=:cd_campania
			)
			group by cd_campania
		)group by 
		tx_variable,
		cd_variable,
		cd_campania";

	const vDetalleCampania=
		"select 
			(select nu_consecutivo_remesa from coreremesa where cd_remesa 
			in (select cd_remesa from coreprocesotecnico where cd_proceso_tecnico=core.cd_proceso_tecnico)
			)||'^Código de Remesa|'||
			cd_proceso_tecnico||'^Código de Proceso Técnico|'||
			cd_campania||'^Código de la Campania|'||
			fe_inicio||'^Fecha de inicio|'||
			nvl(fe_fin,null)||'^Fecha fin|'||
			tx_campania||'^Nombre de la Campania|'||
			case when st_campania=1 then 'Abierta' else 'Cerrada' end||'^Estatus de la Campania|'||
			'# '||nu_consecutivo||'^Contacto de Campania'
			 text, st_campania,nu_consecutivo
			from corecampania core
		where  cd_campania=:cd_campania";
	const vTiposDocumentos="
		select 'V' value, 'Venezolano' text from dual
		union all 
		select 'E' value, 'Extranjero' text from dual
		union all 
		select 'J' value, 'Juridico' text from dual
		union all 
		select 'G' value, 'Gubernamental' text from dual";
	
	const vTiposSexos="
		select 'M' value, 'Masculino' text from dual
		union all 
		select 'F' value, 'Femenino' text from dual
		union all 
		select 'O' value, 'Otros' text from dual";
	
	const vTiposEstadosCiviles="
		select 'C' value, 'Casado/a' text from dual
		union all 
		select 'V' value, 'Viudo/a' text from dual
		union all 
		select 'D' value, 'Divorciado/a' text from dual
		union all 
		select 'S' value, 'Soltero/a' text from dual";

	const vVariablesPadre="
		select cd_variable value, tx_variable text from corevariablescallcenter
		where cd_padre is null and nu_nivel=1 order by cd_relacion desc";
	
	const vVariablesHijos="
		select cd_variable value,tx_variable text from corevariablescallcenter
		where cd_padre=:cd_padre
		order by cd_relacion desc
	";

	const vClientePorDocumento="
	select 
		cd_gestion_remesa,
		tp_documento,
		to_number(nu_documento) nu_documento,
		nm_nombre1,
		nm_apellido1,
		tx_correo,
		nu_telefono,
		nu_telefono_hab,
		mt_suma_asegurada,
		cd_campania,
		to_char(to_date(fe_nacimiento,'dd-mm-yyyy'),'yyyy-mm-dd') fe_nacimiento,
		tx_estado_civil,
		tx_sexo,
		case when (select count(1) from coregestioncampania where cd_gestion_remesa=core.cd_gestion_remesa) <
		(select nu_consecutivo from corecampania where cd_campania=core.cd_campania)then 1 else 0 end in_puede_revisar,
		nvl((select (select in_decision_final from corevariablescallcenter where cd_variable=coca.cd_variable1) from coregestioncampania coca where cd_gestion_campania=
		(select max(cd_gestion_campania) from coregestioncampania where cd_gestion_remesa=core.cd_gestion_remesa )
		),0)in_decision_final
	from coregestionremesa core
	where cd_campania is not null
	and nu_documento=:nu_documento
	";
	const vListaDetalleConErrorEnEmisionPorDocumento="
		select 
			core.cd_gestion_remesa,
			nm_nombre1,
			nm_apellido1,
			tp_documento,
			core.nu_documento,
			tx_estado_civil,
			tx_sexo,
			tx_correo,
			to_char(to_date(fe_nacimiento,'dd-mm-yyyy'),'yyyy-mm-dd')fe_nacimiento,
			nu_telefono,
			nu_telefono_hab
		from coregestionremesa core,
		coregestionemision coem
		where core.cd_gestion_remesa=coem.cd_gestion_remesa
		and core.nu_documento=:nu_documento
		and rownum=1
	";
	const vListaErroresEmisionPorGestionRemesa="
		select tx_mensaje 
		from coregestionemision coem
		where coem.nu_documento=:nu_documento
	";
	const vValidarProcesoTecnico="
	select 
	    case when 
	    trunc(sysdate + (select to_number(cd_valor) from coreparametros
	    where cd_tabla='EM_DIAS_PARA_EMITIR')) > trunc(core.fe_proceso)
	    then
	        1
	    else
	        0
	    end validacion,
	    (select count(1) from coreordenes where cd_programa=3 and parametro1=:cd_proceso_tecnico and st_orden=1) valida_proceso,
	    to_char((fe_proceso+(select to_number(cd_valor) from coreparametros
	    where cd_tabla='EM_DIAS_PARA_EMITIR')),'dd-mm-yyyy') fe_proceso
	from coreprocesotecnico core
	where cd_proceso_tecnico=:cd_proceso_tecnico ";

	const vNivelesDeVariablesCallCenter="
		select count(1) cuenta, nu_nivel,tx_variable , cd_variable 
		from corevariablescallcenter
		where cd_relacion is null and in_dependencia is null
		group by nu_nivel,tx_variable,cd_variable
		order by nu_nivel
	";
	const vVariablesCallCenter="
		select cd_variable value,nu_nivel, tx_variable text,cd_relacion from corevariablescallcenter
		where in_dependencia is not null
		order by tx_variable
	";


	const vBuscarSubNivelesCallCenter="
		select cd_variable value, tx_variable text,cd_relacion,
		nvl((select in_aplica_formulario from corevariablesanexo where cd_variable=core.cd_variable),0) in_aplica_formulario 
		from corevariablescallcenter core
		where  nu_nivel=:nu_nivel
		and cd_relacion is not null
		and cd_relacion=:cd_relacion
		order by tx_variable
	";

	const vActualizarCampania="
				update corecampania
				set st_campania=99
				where cd_campania=:cd_campania
	";
	const vBuscarConsecutivoCampania="select nu_consecutivo from corecampania where cd_campania=:cd_campania";

	const vActualizarConsecutivoCampania="
				update corecampania
				set nu_consecutivo=(select nu_consecutivo+1 from corecampania where cd_campania=:cd_campania)
				where cd_campania=:cd_campania
	";
	const vBuscarRegistrosSinContactarConsecutivo1="
		select cd_gestion_remesa from  coregestionremesa
		where cd_gestion_remesa not in (
			select cd_gestion_remesa from coregestioncampania
			where cd_campania=:cd_campania
			and nu_consecutivo=:nu_consecutivo
		)
		and cd_campania=:cd_campania
		and cd_proceso_tecnico=:cd_proceso_tecnico
	";
	const vBuscarRegistrosSinContactarConsecutivoMayorA1="
		select count(1),cd_gestion_remesa,:cd_proceso_tecnico  from coregestioncampania
		where nu_consecutivo != :nu_consecutivo 
		and cd_gestion_remesa not in (
			select cd_gestion_remesa from coregestioncampania
			where cd_campania=:cd_campania
			and st_gestion_campania=1
		)
		and cd_campania=:cd_campania
		group by cd_gestion_remesa";

	
	const vActualizarProcesoDeCampania="
				update coreprocesotecnico
				set in_solicitud_campania=1
				where cd_proceso_tecnico=:cd_proceso_tecnico
	";

	const vListadoDeContactosPorVariables="
		select
		    (select '80'||nu_telefono from coregestionremesa where cd_gestion_remesa=a1.cd_gestion_Remesa)||';'||
		    (select nu_documento||' '||nm_nombre1||' '||nm_apellido1  from coregestionremesa where cd_gestion_remesa=a1.cd_gestion_Remesa) valor 
		from (
		    select 
		    max(cd_gestion_campania) cd_gestion_campania,
		    core.cd_gestion_remesa,
		    camp.cd_campania
		    from coregestionremesa core,coregestioncampania camp
		    where core.cd_proceso_tecnico=:cd_proceso_tecnico
		    and core.cd_campania=:cd_campania
		    and core.cd_gestion_remesa=camp.cd_gestion_remesa
		    and core.cd_campania=camp.cd_campania
		    group by core.cd_gestion_remesa,camp.cd_campania
		)a1
		where (select cd_variable1 from coregestioncampania where cd_gestion_campania=a1.cd_gestion_campania)=:cd_variable ";
	const vListadoDeContactosSinGestionar="
		select
		    (select '80'||nu_telefono from coregestionremesa where cd_gestion_remesa=a1.cd_gestion_Remesa)||';'||
		    (select nu_documento||' '||nm_nombre1||' '||nm_apellido1  from coregestionremesa where cd_gestion_remesa=a1.cd_gestion_Remesa) valor,
		    :cd_variable cd_campania 
		from (
		    select 
		    core.cd_gestion_remesa,
		    'Sin Gestionar' tx_variable,
		    0 cd_variable,
		    core.cd_campania
		    from coregestionremesa core
		    where  core.cd_proceso_tecnico=:cd_proceso_tecnico
		    and core.cd_campania=:cd_campania
		    and core.cd_gestion_remesa not in (
		        select cd_gestion_remesa from coregestioncampania where cd_campania=:cd_campania
		    )
		)a1
	";
	const vCantidadContactosPorDocumento="
		select 
        count(1) valor
		from coregestionremesa core, coregestioncampania camp
		where core.cd_campania=camp.cd_campania
		and core.cd_gestion_remesa=camp.cd_gestion_remesa
		and 
		core.cd_campania is not null
		and nu_documento=:nu_documento
	";
	const vListarParametros="
		select cd_valor value ,cd_valor text from coreparametros where cd_tabla=:cd_tabla order by cd_valor
	";

	const vListarParametrosMust="
		select cd_valor value, substr(cd_tabla,3,length(cd_tabla)) text from coreparametros where substr(cd_tabla,1,1)=:cd_tabla
		order by cd_valor asc
	";

	const vValorParametro="
		select cd_valor value,cd_parametro text from coreparametros where cd_tabla=:cd_tabla
		order by cd_valor asc
	";

	const vListarVariablesPadre="
		select cd_variable value,tx_variable text from corevariablescallcenter
		where nu_nivel=(:nu_nivel)-1
		order by in_dependencia desc
	";
	const vListarVariablesPorNivel="
		select cd_variable,tx_variable,cd_relacion,in_dependencia,cd_accion,in_decision_final,nu_nivel 
		from corevariablescallcenter
		where nu_nivel=:nu_nivel
		order by cd_relacion desc
	";
	const vListarVariablesPorNivelSelect="
		select cd_variable value ,tx_variable text, '6' col, 'Variable Para Cierre de Contacto' title
		from corevariablescallcenter
		where nu_nivel=:nu_nivel
		order by cd_relacion desc
	";
	const vBuscarAccionVariable="select nvl(cd_accion,0) cd_accion from corevariablescallcenter
		where cd_variable=:cd_variable";

	const vBuscarDatosDeContactoDelCliente="select nm_nombre1 ||' '||nm_apellido1 nm_cliente, tx_correo 
	from coregestionremesa where cd_gestion_remesa=:cd_gestion_remesa";

	const vBuscarDetalleContactosClientePorDocumento=
	"select 
	   'Resumen contacto n°'||nu_consecutivo||': '||(select tx_variable from corevariablescallcenter where cd_variable=core.cd_variable0) || 
	   case when nvl(core.cd_variable1,0)>0 then
	       ' >'||(select tx_variable from corevariablescallcenter where cd_variable=core.cd_variable1)||' '||
	       case when nvl(core.cd_variable2,0)>0 then
	            ' >'||(select tx_variable from corevariablescallcenter where cd_variable=core.cd_variable2)||' '||
	           case when nvl(core.cd_variable3,0)>0 then
	                ' >'||(select tx_variable from corevariablescallcenter where cd_variable=core.cd_variable3)||' '|| 
	                case when nvl(core.cd_variable4,0)>0 then
	                    ' >'||(select tx_variable from corevariablescallcenter where cd_variable=core.cd_variable4)||' '||
	                        case when nvl(core.cd_variable5,0)>0 then
	                            ' >'||(select tx_variable from corevariablescallcenter where cd_variable=core.cd_variable5)
	                        else
	                            ''
	                        end
	                else
	                    ''
	                end
	           else
	            ''
	           end
	       else
	        ''
	       end
	       
	   else
	       ''
	   end tx_contacto
	from coregestioncampania core, coregestionremesa gest
			
	where core.cd_gestion_Remesa=gest.cd_gestion_remesa
	and nu_documento=:nu_documento";
	const vBuscarBalanceRemesa="
	select sum(ca_registros)ca_registros, text
		from (
		    select count(1) ca_registros,'<b>Data Cargada</b>' text,1 cd_orden  from coregestionremesa
		    where cd_remesa=:cd_remesa
		    union all
		    select count(1) ca_registros,'<b>Data Óptima</b>' text ,2 cd_orden from coregestionremesa core
		    where cd_remesa=:cd_remesa
		    and core.IN_VALIDAPRIMERAPELLIDO=1
		    and in_validaprimernombre=1 and                               
		    in_validaprimerapellido=1 and   
		    in_validanudocumento=1 and   
		    in_valida_correo=1 and   
		    in_valida_telefono_movil=1 and   
		    in_valida_telefono_local=1 and   
		    in_valida_fecha_nacimiento=1 and   
		    in_duplicado is null 
		    union all
		    select count(1)ca_registros,'<b>Data No Óptima</b>' text, 4 cd_orden from coregestionremesa core
		    where cd_remesa=:cd_remesa
		    and core.IN_VALIDAPRIMERAPELLIDO=0
		    and in_validaprimernombre=0 and                               
		    in_validaprimerapellido=0 and   
		    in_validanudocumento=0 and   
		    in_valida_correo=0 and   
		    in_valida_telefono_movil=0 and   
		    in_valida_telefono_local=0 and   
		    in_valida_fecha_nacimiento=0
		    and in_duplicado is null
		    union all
		    select count(1)ca_registros,'<b>Data No Óptima</b>' text, 4 cd_orden  from coregestionremesa core
		    where cd_remesa=:cd_remesa
		    and in_duplicado is not null
		    union all
		    select count(1) ca_registros,'Procesos Tecnicos' text, 3 cd_orden from coregestionremesa core
		    where cd_remesa=:cd_remesa
		    and core.IN_VALIDAPRIMERAPELLIDO=1
		    and in_validaprimernombre=1 and                               
		    in_validaprimerapellido=1 and   
		    in_validanudocumento=1 and   
		    in_valida_correo=1 and   
		    in_valida_telefono_movil=1 and   
		    in_valida_telefono_local=1 and   
		    in_valida_fecha_nacimiento=1 and   
		    in_duplicado is null 
		    and cd_proceso_tecnico is not null
		)a1
	group by text,cd_orden
	order by cd_orden asc
	";
	const vBuscarFormularioTecnico="
		select in_aplica_formulario from corevariablesanexo where cd_variable=:cd_variable 
	";

	const vBuscarGruposFamiliaresPorSuma="
		select 
			case when de_dato like '%TCH %' then 'TCH' else 'THCP' end text,
			case when de_dato like '%TCH %' then 1 else 2 end value,
			'Grupo Familiar' title,
			'6' col 

		from TABLAINFORMACION
		where 
			cd_tabla=410001
			and va_dato1=1
			and va_dato2=504
			group by case when de_dato like '%TCH %' then 'TCH' else 'THCP' end,case when de_dato like '%TCH %' then 1 else 2 end
	";
	const vSumasAseguradasPorDato="
		select 
		    va_dato3 value,de_dato text, 'Suma Asegurada' title, 6 col
		from TABLAINFORMACION
		where cd_tabla=410001
		and va_dato1=1
		and va_dato2=504
		and (case when de_dato like '%TCH %' then 1 else 2 end)=:cd_variable
		and va_dato3!= (select mt_suma_asegurada 
						from coreprocesotecnico
						where cd_proceso_tecnico in (
						select cd_proceso_tecnico from corecampania
						where cd_campania=:cd_campania)
						)
		order by de_dato
	";

	const vFamiliaresAdicionales="
		select 
		    1 value,'Un Familiar' text, 'Familiares Adicionales' title, 6 col
		from dual
		union all
		select 
		    2 value,'Dos Familiares' text, 'Familiares Adicionales' title, 6 col
		from dual
		union all
		select 
		    3 value,'Tres Familiares' text, 'Familiares Adicionales' title, 6 col
		from dual
		union all
		select 
		    4 value,'Cuatro Familiares' text, 'Familiares Adicionales' title, 6 col
		from dual  
		union all
		select 
		    5 value,'Cinco Familiares' text, 'Familiares Adicionales' title, 6 col
		from dual  
		union all
		select 
		    6 value,'Seis Familiares' text, 'Familiares Adicionales' title, 6 col
		from dual
		union all
		select 
		    7 value,'Siete Familiares' text, 'Familiares Adicionales' title, 6 col
		from dual
		union all
		select 
		    8 value,'Ocho Familiares' text, 'Familiares Adicionales' title, 6 col
		from dual
	";

	const vBuscarParentescos='select cd_parentesco, de_parentesco from parentesco
	order by cd_parentesco';

	const vBuscarVariableRelacionada =
	'select cd_variable value from corevariablescallcenter
	where cd_variable=
	(
		select cd_relacion from corevariablescallcenter
		where cd_variable=:cd_variable
	)';
	const vActualizarProcesoCampaniaEnRemesa="
		update coregestionremesa
		set cd_proceso_campania=:cd_proceso_campania
		where cd_gestion_remesa in (
		select cd_gestion_remesa 
		from  coregestioncampania coca
		where cd_campania=:cd_campania 
		and 
			(select cd_accion from corevariablescallcenter where coca.CD_VARIABLE1=cd_variable )=2
		)
		and in_valida_emision=200
	";

	const vListadoCampaniasProceso="
		select 
		prca.cd_campania value ,
		'CAMPANIA-COD-'||prca.cd_campania||'-'||(to_char(fe_inicio,'dd/mm/yyyy')) text
		from corecampania camp, COREPROCESOCAMPANIA prca
		where 
		camp.CD_CAMPANIA= prca.cd_campania
		and st_campania=1
		order by prca.cd_campania desc";

	const vListadoProcesosTecnicosCampania="
	select 
		cd_proceso_campania||'-'||cd_campania value,
		'CAMPANIA - '||cd_campania||' - CONTACTO #'||nu_consecutivo||' - '||(to_char(fe_proceso,'dd/mm/yyyy')) text 
	from coreprocesocampania
	where cd_campania=:cd_campania";


	const vPanelGeneralEmisionCampania="
	select 
	    (select count(1) from coregestionremesa where cd_campania=core.cd_campania and cd_proceso_campania=core.cd_proceso_campania and cd_campania=:cd_campania) ca_registros,
	    cd_proceso_campania,
	    cd_campania,
	    fe_proceso,
	    in_solicitud_seguros,
	    in_emision,
	    in_cuadro_poliza,
	    nu_consecutivo
	from COREPROCESOCAMPANIA core
	where  cd_proceso_campania=:cd_proceso_campania
	and core.cd_campania=:cd_campania
	order by cd_proceso_campania";

	const vDetalleProcesoCampania="
	select 
	    cd_campania||'^Código de Campania|'||
	    nu_consecutivo||'^Contacto # |'||
	    to_char(fe_proceso,'dd/mm/yyyy')||'^Fecha de Proceso|'||
	    'CAMPANIA-COD -'||cd_campania||' - Contacto # '||nu_consecutivo ||'^Nombre del Contanto|'||
	    case when st_proceso_campania=1 then 'Abierto' else 'Cerrado' end||'^Estatus del Consecutivo' text
	from coreprocesocampania
	where cd_proceso_campania=:cd_proceso_campania
	and cd_campania=:cd_campania
	";
	
	const vActualizarProcesoTecnicoEmision='
	update coreprocesocampania 
		set :tx_campo=:in_valor
	where cd_proceso_campania=:cd_proceso_campania';
	const vActualizarGestionRemesaDeProcesoTecnicoEmision='
	update coregestionremesa 
		set :tx_campo=:in_valor,st_gestion_remesa=4
	where cd_proceso_campania=:cd_proceso_campania';

	const vEstatusOrdenEmision="
		select (select 

		decode(st_orden,
		    1,'En Ejecucion',
		    2,'En Proceso',
		    3,'Culminado'
		,'N/A') 

		from coreordenes
		where cd_orden=a1.cd_orden) st_orden
		from (
		select max(cd_orden) cd_orden from coreordenes
		where parametro1=:cd_proceso_tecnico
		)a1";

	const vLogEmision="
		select cd_orden,tx_log,cd_dato from corelog 
		where cd_orden=:cd_proceso_tecnico";

	const vListaDetalleDataPorDocumento="
		select 
			core.cd_gestion_remesa,
			nm_nombre1,
			nm_apellido1,
			tp_documento,
			core.nu_documento,
			tx_estado_civil,
			tx_sexo,
			tx_correo,
			to_char(to_date(fe_nacimiento,'dd-mm-yyyy'),'yyyy-mm-dd')fe_nacimiento,
			nu_telefono,
			nu_telefono_hab
		from coregestionremesa core
		where  core.nu_documento=:nu_documento
		and in_duplicado is null
		and st_gestion_remesa in (3)
	";
	const vListaDetalleDataCampania="
		select 
			core.cd_gestion_remesa,
			nm_nombre1,
			nm_apellido1,
			tp_documento,
			core.nu_documento,
			tx_estado_civil,
			tx_sexo,
			tx_correo,
			to_char(to_date(fe_nacimiento,'dd-mm-yyyy'),'yyyy-mm-dd')fe_nacimiento,
			nu_telefono,
			nu_telefono_hab
		from coregestionremesa core
		where  core.nu_documento=:nu_documento
		and in_duplicado is null
		and st_gestion_remesa in (4)
	";
	const vAdicionalesPorDocumento=
	"select 
	    (select de_parentesco from parentesco where cd_parentesco=adic.cd_parentesco)parentesco,
	    nm_nombre_completo,
	    fe_nacimiento,
	    nu_area,
	    nu_telefono,
	    tp_documento,
	    nu_documento
	from coregestionadicionales adic
	where cd_gestion_remesa in (
	    select cd_gestion_remesa from COREGESTIONREMESA
	    where nu_documento=:nu_documento
	    and in_duplicado is null
	    and st_gestion_remesa>=3
	)";

	const vPorcetajeComercialCampania='select po_descuento from coreprocesotecnico
		where cd_proceso_tecnico=:cd_proceso_tecnico';
}