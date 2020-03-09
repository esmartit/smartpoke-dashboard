--
-- PostgreSQL database dump
--

-- Dumped from database version 11.7
-- Dumped by pg_dump version 11.3

-- Started on 2020-02-26 14:48:23 CET

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

CREATE SCHEMA smartpoke;

ALTER SCHEMA smartpoke OWNER TO esmartitpg;

--
-- TOC entry 256 (class 1255 OID 17837)
-- Name: actualizar_linea_total_sensortotal(character varying, date, character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: smartpoke; Owner: esmartitpg
--

CREATE FUNCTION smartpoke.actualizar_linea_total_sensortotal(p_spot_id character varying, p_acctdate date, p_sensorname character varying, p_devicemac character varying, p_devicehashmac character varying, p_brand character varying) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
<< principal >>
DECLARE

-- registros de trabajo

 reg_in_sensortotal "smartpoke".rw_sensortotal%ROWTYPE;
 reg_limit_sensortotal "smartpoke".rw_sensortotal%ROWTYPE;
 reg_out_sensortotal "smartpoke".rw_sensortotal%ROWTYPE;

 w_sensortotal "smartpoke".rw_sensortotal%ROWTYPE;

-- variables de trabajo

 w_retorno int;
 w_exis boolean := false;
 w_count int2 := 0;

BEGIN

    w_sensortotal.spot_id := p_spot_id;
	w_sensortotal.acctdate := p_acctdate;
	w_sensortotal.pos := 'TOTAL';
	w_sensortotal.sensorname := p_sensorname;
	w_sensortotal.devicemac := p_devicemac;
	w_sensortotal.devicehashmac := p_devicehashmac;
	w_sensortotal.brand := p_brand;

   -- Lo primero que hago es intentar leer los registros de 'IN', 'LIMIT', 'OUT'
   BEGIN
     	select * into strict reg_in_sensortotal
		   from "smartpoke".rw_sensortotal
		  where spot_id = w_sensortotal.spot_id and
		        acctdate = w_sensortotal.acctdate and
		        pos = 'IN' and
			    sensorname = w_sensortotal.sensorname and
			    devicemac = w_sensortotal.devicemac and
			    devicehashmac = w_sensortotal.devicehashmac;
   EXCEPTION
     WHEN NO_DATA_FOUND THEN
	    null;
  	WHEN OTHERS THEN
		RETURN  'Error '||SQLSTATE||' en la linea de total';
   END;
   BEGIN
    	select * into strict reg_limit_sensortotal
		   from "smartpoke".rw_sensortotal
		  where spot_id = w_sensortotal.spot_id and
		        acctdate = w_sensortotal.acctdate and
		        pos = 'LIMIT' and
			    sensorname = w_sensortotal.sensorname and
			    devicemac = w_sensortotal.devicemac and
			    devicehashmac = w_sensortotal.devicehashmac;
   EXCEPTION
     WHEN NO_DATA_FOUND THEN
	    null;
  	WHEN OTHERS THEN
		RETURN  'Error '||SQLSTATE||' en la linea de total';
   END;
     BEGIN
    	select * into strict reg_out_sensortotal
		   from "smartpoke".rw_sensortotal
		  where spot_id = w_sensortotal.spot_id and
		        acctdate = w_sensortotal.acctdate and
		        pos = 'OUT' and
			    sensorname = w_sensortotal.sensorname and
			    devicemac = w_sensortotal.devicemac and
			    devicehashmac = w_sensortotal.devicehashmac;
   EXCEPTION
     WHEN NO_DATA_FOUND THEN
	    null;
  	WHEN OTHERS THEN
		RETURN  'Error '||SQLSTATE||' en la linea de total';
   END;

   -- Compruebo si ya existe la línea de totales para su futura actualización
    select count(*) into w_count
	   from "smartpoke".rw_sensortotal
	   where spot_id = w_sensortotal.spot_id and
	        acctdate = w_sensortotal.acctdate and
	        pos = 'TOTAL' and
		    sensorname = w_sensortotal.sensorname and
		    devicemac = w_sensortotal.devicemac and
		    devicehashmac = w_sensortotal.devicehashmac;

    if w_count = 1
    then
		w_exis := true;
    end if;

    -- Actualizo las columnas de totales de acuerdo al criterio de si hay valor en IN prevalece sobre el resto y el de LIMIT sobre el de OUT

	Case
	 when COALESCE(reg_in_sensortotal.tim00,0) > 0 then
	   w_sensortotal.tim00 := COALESCE(reg_in_sensortotal.tim00,0);
	   w_sensortotal.num00 := COALESCE(reg_in_sensortotal.num00,0);
	 when COALESCE(reg_limit_sensortotal.tim00,0) > 0 then
	   w_sensortotal.tim00 := COALESCE(reg_limit_sensortotal.tim00,0);
	   w_sensortotal.num00 := COALESCE(reg_limit_sensortotal.num00,0);
	else
	   w_sensortotal.tim00 := COALESCE(reg_out_sensortotal.tim00,0);
	   w_sensortotal.num00 := COALESCE(reg_out_sensortotal.num00,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim01,0) > 0 then
	   w_sensortotal.tim01 := COALESCE(reg_in_sensortotal.tim01,0);
	   w_sensortotal.num01 := COALESCE(reg_in_sensortotal.num01,0);
	 when COALESCE(reg_limit_sensortotal.tim01,0) > 0 then
	   w_sensortotal.tim01 := COALESCE(reg_limit_sensortotal.tim01,0);
	   w_sensortotal.num01 := COALESCE(reg_limit_sensortotal.num01,0);
	else
	   w_sensortotal.tim01 := COALESCE(reg_out_sensortotal.tim01,0);
	   w_sensortotal.num01 := COALESCE(reg_out_sensortotal.num01,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim02,0) > 0 then
	   w_sensortotal.tim02 := COALESCE(reg_in_sensortotal.tim02,0);
	   w_sensortotal.num02 := COALESCE(reg_in_sensortotal.num02,0);
	 when COALESCE(reg_limit_sensortotal.tim02,0) > 0 then
	   w_sensortotal.tim02 := COALESCE(reg_limit_sensortotal.tim02,0);
	   w_sensortotal.num02 := COALESCE(reg_limit_sensortotal.num02,0);
	else
	   w_sensortotal.tim02 := COALESCE(reg_out_sensortotal.tim02,0);
	   w_sensortotal.num02 := COALESCE(reg_out_sensortotal.num02,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim03,0) > 0 then
	   w_sensortotal.tim03 := COALESCE(reg_in_sensortotal.tim03,0);
	   w_sensortotal.num03 := COALESCE(reg_in_sensortotal.num03,0);
	 when COALESCE(reg_limit_sensortotal.tim03,0) > 0 then
	   w_sensortotal.tim03 := COALESCE(reg_limit_sensortotal.tim03,0);
	   w_sensortotal.num03 := COALESCE(reg_limit_sensortotal.num03,0);
	else
	   w_sensortotal.tim03 := COALESCE(reg_out_sensortotal.tim03,0);
	   w_sensortotal.num03 := COALESCE(reg_out_sensortotal.num03,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim04,0) > 0 then
	   w_sensortotal.tim04 := COALESCE(reg_in_sensortotal.tim04,0);
	   w_sensortotal.num04 := COALESCE(reg_in_sensortotal.num04,0);
	 when COALESCE(reg_limit_sensortotal.tim04,0) > 0 then
	   w_sensortotal.tim04 := COALESCE(reg_limit_sensortotal.tim04,0);
	   w_sensortotal.num04 := COALESCE(reg_limit_sensortotal.num04,0);
	else
	   w_sensortotal.tim04 := COALESCE(reg_out_sensortotal.tim04,0);
	   w_sensortotal.num04 := COALESCE(reg_out_sensortotal.num04,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim05,0) > 0 then
	   w_sensortotal.tim05 := COALESCE(reg_in_sensortotal.tim05,0);
	   w_sensortotal.num05 := COALESCE(reg_in_sensortotal.num05,0);
	 when COALESCE(reg_limit_sensortotal.tim05,0) > 0 then
	   w_sensortotal.tim05 := COALESCE(reg_limit_sensortotal.tim05,0);
	   w_sensortotal.num05 := COALESCE(reg_limit_sensortotal.num05,0);
	else
	   w_sensortotal.tim05 := COALESCE(reg_out_sensortotal.tim05,0);
	   w_sensortotal.num05 := COALESCE(reg_out_sensortotal.num05,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim06,0) > 0 then
	   w_sensortotal.tim06 := COALESCE(reg_in_sensortotal.tim06,0);
	   w_sensortotal.num06 := COALESCE(reg_in_sensortotal.num06,0);
	 when COALESCE(reg_limit_sensortotal.tim06,0) > 0 then
	   w_sensortotal.tim06 := COALESCE(reg_limit_sensortotal.tim06,0);
	   w_sensortotal.num06 := COALESCE(reg_limit_sensortotal.num06,0);
	else
	   w_sensortotal.tim06 := COALESCE(reg_out_sensortotal.tim06,0);
	   w_sensortotal.num06 := COALESCE(reg_out_sensortotal.num06,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim07,0) > 0 then
	   w_sensortotal.tim07 := COALESCE(reg_in_sensortotal.tim07,0);
	   w_sensortotal.num07 := COALESCE(reg_in_sensortotal.num07,0);
	 when COALESCE(reg_limit_sensortotal.tim07,0) > 0 then
	   w_sensortotal.tim07 := COALESCE(reg_limit_sensortotal.tim07,0);
	   w_sensortotal.num07 := COALESCE(reg_limit_sensortotal.num07,0);
	else
	   w_sensortotal.tim07 := COALESCE(reg_out_sensortotal.tim07,0);
	   w_sensortotal.num07 := COALESCE(reg_out_sensortotal.num07,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim08,0) > 0 then
	   w_sensortotal.tim08 := COALESCE(reg_in_sensortotal.tim08,0);
	   w_sensortotal.num08 := COALESCE(reg_in_sensortotal.num08,0);
	 when COALESCE(reg_limit_sensortotal.tim08,0) > 0 then
	   w_sensortotal.tim08 := COALESCE(reg_limit_sensortotal.tim08,0);
	   w_sensortotal.num08 := COALESCE(reg_limit_sensortotal.num08,0);
	else
	   w_sensortotal.tim08 := COALESCE(reg_out_sensortotal.tim08,0);
	   w_sensortotal.num08 := COALESCE(reg_out_sensortotal.num08,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim09,0) > 0 then
	   w_sensortotal.tim09 := COALESCE(reg_in_sensortotal.tim09,0);
	   w_sensortotal.num09 := COALESCE(reg_in_sensortotal.num09,0);
	 when COALESCE(reg_limit_sensortotal.tim09,0) > 0 then
	   w_sensortotal.tim09 := COALESCE(reg_limit_sensortotal.tim09,0);
	   w_sensortotal.num09 := COALESCE(reg_limit_sensortotal.num09,0);
	else
	   w_sensortotal.tim09 := COALESCE(reg_out_sensortotal.tim09,0);
	   w_sensortotal.num09 := COALESCE(reg_out_sensortotal.num09,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim10,0) > 0 then
	   w_sensortotal.tim10 := COALESCE(reg_in_sensortotal.tim10,0);
	   w_sensortotal.num10 := COALESCE(reg_in_sensortotal.num10,0);
	 when COALESCE(reg_limit_sensortotal.tim10,0) > 0 then
	   w_sensortotal.tim10 := COALESCE(reg_limit_sensortotal.tim10,0);
	   w_sensortotal.num10 := COALESCE(reg_limit_sensortotal.num10,0);
	else
	   w_sensortotal.tim10 := COALESCE(reg_out_sensortotal.tim10,0);
	   w_sensortotal.num10 := COALESCE(reg_out_sensortotal.num10,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim11,0) > 0 then
	   w_sensortotal.tim11 := COALESCE(reg_in_sensortotal.tim11,0);
	   w_sensortotal.num11 := COALESCE(reg_in_sensortotal.num11,0);
	 when COALESCE(reg_limit_sensortotal.tim11,0) > 0 then
	   w_sensortotal.tim11 := COALESCE(reg_limit_sensortotal.tim11,0);
	   w_sensortotal.num11 := COALESCE(reg_limit_sensortotal.num11,0);
	else
	   w_sensortotal.tim11 := COALESCE(reg_out_sensortotal.tim11,0);
	   w_sensortotal.num11 := COALESCE(reg_out_sensortotal.num11,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim12,0) > 0 then
	   w_sensortotal.tim12 := COALESCE(reg_in_sensortotal.tim12,0);
	   w_sensortotal.num12 := COALESCE(reg_in_sensortotal.num12,0);
	 when COALESCE(reg_limit_sensortotal.tim12,0) > 0 then
	   w_sensortotal.tim12 := COALESCE(reg_limit_sensortotal.tim12,0);
	   w_sensortotal.num12 := COALESCE(reg_limit_sensortotal.num12,0);
	else
	   w_sensortotal.tim12 := COALESCE(reg_out_sensortotal.tim12,0);
	   w_sensortotal.num12 := COALESCE(reg_out_sensortotal.num12,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim13,0) > 0 then
	   w_sensortotal.tim13 := COALESCE(reg_in_sensortotal.tim13,0);
	   w_sensortotal.num13 := COALESCE(reg_in_sensortotal.num13,0);
	 when COALESCE(reg_limit_sensortotal.tim13,0) > 0 then
	   w_sensortotal.tim13 := COALESCE(reg_limit_sensortotal.tim13,0);
	   w_sensortotal.num13 := COALESCE(reg_limit_sensortotal.num13,0);
	else
	   w_sensortotal.tim13 := COALESCE(reg_out_sensortotal.tim13,0);
	   w_sensortotal.num13 := COALESCE(reg_out_sensortotal.num13,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim14,0) > 0 then
	   w_sensortotal.tim14 := COALESCE(reg_in_sensortotal.tim14,0);
	   w_sensortotal.num14 := COALESCE(reg_in_sensortotal.num14,0);
	 when COALESCE(reg_limit_sensortotal.tim14,0) > 0 then
	   w_sensortotal.tim14 := COALESCE(reg_limit_sensortotal.tim14,0);
	   w_sensortotal.num14 := COALESCE(reg_limit_sensortotal.num14,0);
	else
	   w_sensortotal.tim14 := COALESCE(reg_out_sensortotal.tim14,0);
	   w_sensortotal.num14 := COALESCE(reg_out_sensortotal.num14,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim15,0) > 0 then
	   w_sensortotal.tim15 := COALESCE(reg_in_sensortotal.tim15,0);
	   w_sensortotal.num15 := COALESCE(reg_in_sensortotal.num15,0);
	 when COALESCE(reg_limit_sensortotal.tim15,0) > 0 then
	   w_sensortotal.tim15 := COALESCE(reg_limit_sensortotal.tim15,0);
	   w_sensortotal.num15 := COALESCE(reg_limit_sensortotal.num15,0);
	else
	   w_sensortotal.tim15 := COALESCE(reg_out_sensortotal.tim15,0);
	   w_sensortotal.num15 := COALESCE(reg_out_sensortotal.num15,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim16,0) > 0 then
	   w_sensortotal.tim16 := COALESCE(reg_in_sensortotal.tim16,0);
	   w_sensortotal.num16 := COALESCE(reg_in_sensortotal.num16,0);
	 when COALESCE(reg_limit_sensortotal.tim16,0) > 0 then
	   w_sensortotal.tim16 := COALESCE(reg_limit_sensortotal.tim16,0);
	   w_sensortotal.num16 := COALESCE(reg_limit_sensortotal.num16,0);
	else
	   w_sensortotal.tim16 := COALESCE(reg_out_sensortotal.tim16,0);
	   w_sensortotal.num16 := COALESCE(reg_out_sensortotal.num16,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim17,0) > 0 then
	   w_sensortotal.tim17 := COALESCE(reg_in_sensortotal.tim17,0);
	   w_sensortotal.num17 := COALESCE(reg_in_sensortotal.num17,0);
	 when COALESCE(reg_limit_sensortotal.tim17,0) > 0 then
	   w_sensortotal.tim17 := COALESCE(reg_limit_sensortotal.tim17,0);
	   w_sensortotal.num17 := COALESCE(reg_limit_sensortotal.num17,0);
	else
	   w_sensortotal.tim17 := COALESCE(reg_out_sensortotal.tim17,0);
	   w_sensortotal.num17 := COALESCE(reg_out_sensortotal.num17,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim18,0) > 0 then
	   w_sensortotal.tim18 := COALESCE(reg_in_sensortotal.tim18,0);
	   w_sensortotal.num18 := COALESCE(reg_in_sensortotal.num18,0);
	 when COALESCE(reg_limit_sensortotal.tim18,0) > 0 then
	   w_sensortotal.tim18 := COALESCE(reg_limit_sensortotal.tim18,0);
	   w_sensortotal.num18 := COALESCE(reg_limit_sensortotal.num18,0);
	else
	   w_sensortotal.tim18 := COALESCE(reg_out_sensortotal.tim18,0);
	   w_sensortotal.num18 := COALESCE(reg_out_sensortotal.num18,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim19,0) > 0 then
	   w_sensortotal.tim19 := COALESCE(reg_in_sensortotal.tim19,0);
	   w_sensortotal.num19 := COALESCE(reg_in_sensortotal.num19,0);
	 when COALESCE(reg_limit_sensortotal.tim19,0) > 0 then
	   w_sensortotal.tim19 := COALESCE(reg_limit_sensortotal.tim19,0);
	   w_sensortotal.num19 := COALESCE(reg_limit_sensortotal.num19,0);
	else
	   w_sensortotal.tim19 := COALESCE(reg_out_sensortotal.tim19,0);
	   w_sensortotal.num19 := COALESCE(reg_out_sensortotal.num19,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim20,0) > 0 then
	   w_sensortotal.tim20 := COALESCE(reg_in_sensortotal.tim20,0);
	   w_sensortotal.num20 := COALESCE(reg_in_sensortotal.num20,0);
	 when COALESCE(reg_limit_sensortotal.tim20,0) > 0 then
	   w_sensortotal.tim20 := COALESCE(reg_limit_sensortotal.tim20,0);
	   w_sensortotal.num20 := COALESCE(reg_limit_sensortotal.num20,0);
	else
	   w_sensortotal.tim20 := COALESCE(reg_out_sensortotal.tim20,0);
	   w_sensortotal.num20 := COALESCE(reg_out_sensortotal.num20,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim21,0) > 0 then
	   w_sensortotal.tim21 := COALESCE(reg_in_sensortotal.tim21,0);
	   w_sensortotal.num21 := COALESCE(reg_in_sensortotal.num21,0);
	 when COALESCE(reg_limit_sensortotal.tim21,0) > 0 then
	   w_sensortotal.tim21 := COALESCE(reg_limit_sensortotal.tim21,0);
	   w_sensortotal.num21 := COALESCE(reg_limit_sensortotal.num21,0);
	else
	   w_sensortotal.tim21 := COALESCE(reg_out_sensortotal.tim21,0);
	   w_sensortotal.num21 := COALESCE(reg_out_sensortotal.num21,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim22,0) > 0 then
	   w_sensortotal.tim22 := COALESCE(reg_in_sensortotal.tim22,0);
	   w_sensortotal.num22 := COALESCE(reg_in_sensortotal.num22,0);
	 when COALESCE(reg_limit_sensortotal.tim22,0) > 0 then
	   w_sensortotal.tim22 := COALESCE(reg_limit_sensortotal.tim22,0);
	   w_sensortotal.num22 := COALESCE(reg_limit_sensortotal.num22,0);
	else
	   w_sensortotal.tim22 := COALESCE(reg_out_sensortotal.tim22,0);
	   w_sensortotal.num22 := COALESCE(reg_out_sensortotal.num22,0);
	end case;

	Case
	 when COALESCE(reg_in_sensortotal.tim23,0) > 0 then
	   w_sensortotal.tim23 := COALESCE(reg_in_sensortotal.tim23,0);
	   w_sensortotal.num23 := COALESCE(reg_in_sensortotal.num23,0);
	 when COALESCE(reg_limit_sensortotal.tim23,0) > 0 then
	   w_sensortotal.tim23 := COALESCE(reg_limit_sensortotal.tim23,0);
	   w_sensortotal.num23 := COALESCE(reg_limit_sensortotal.num23,0);
	else
	   w_sensortotal.tim23 := COALESCE(reg_out_sensortotal.tim23,0);
	   w_sensortotal.num23 := COALESCE(reg_out_sensortotal.num23,0);
	end case;


	-- Con la información actualizada, podemos llamar al proceso de actualizar la tabla
	select "smartpoke".actualizar_sensortotal
	    (w_sensortotal.spot_id, w_sensortotal.acctdate, w_sensortotal.pos, w_sensortotal.sensorname,
		w_sensortotal.devicemac, w_sensortotal.devicehashmac, w_sensortotal.brand,
		w_sensortotal.tim00, w_sensortotal.num00, w_sensortotal.tim01, w_sensortotal.num01, w_sensortotal.tim02, w_sensortotal.num02,
		w_sensortotal.tim03, w_sensortotal.num03, w_sensortotal.tim04, w_sensortotal.num04, w_sensortotal.tim05, w_sensortotal.num05,
		w_sensortotal.tim06, w_sensortotal.num06, w_sensortotal.tim07, w_sensortotal.num07, w_sensortotal.tim08, w_sensortotal.num08,
		w_sensortotal.tim09, w_sensortotal.num09, w_sensortotal.tim10, w_sensortotal.num10, w_sensortotal.tim11, w_sensortotal.num11,
		w_sensortotal.tim12, w_sensortotal.num12, w_sensortotal.tim13, w_sensortotal.num13, w_sensortotal.tim14, w_sensortotal.num14,
		w_sensortotal.tim15, w_sensortotal.num15, w_sensortotal.tim16, w_sensortotal.num16, w_sensortotal.tim17, w_sensortotal.num17,
		w_sensortotal.tim18, w_sensortotal.num18, w_sensortotal.tim19, w_sensortotal.num19, w_sensortotal.tim20, w_sensortotal.num20,
		w_sensortotal.tim21, w_sensortotal.num21, w_sensortotal.tim22, w_sensortotal.num22, w_sensortotal.tim23, w_sensortotal.num23,
		w_exis)
	    into w_retorno;

   RETURN 'OK';
EXCEPTION
  WHEN OTHERS THEN
	RETURN  'Error '||SQLSTATE||' en la linea de total';

END;

$$;


ALTER FUNCTION smartpoke.actualizar_linea_total_sensortotal(p_spot_id character varying, p_acctdate date, p_sensorname character varying, p_devicemac character varying, p_devicehashmac character varying, p_brand character varying) OWNER TO esmartitpg;

--
-- TOC entry 257 (class 1255 OID 17839)
-- Name: actualizar_linea_total_smartpoketotal(character varying, date, character varying, character varying, character varying); Type: FUNCTION; Schema: smartpoke; Owner: esmartitpg
--

CREATE FUNCTION smartpoke.actualizar_linea_total_smartpoketotal(p_spot_id character varying, p_acctdate date, p_sensorname character varying, p_callingstationid character varying, p_brand character varying) RETURNS character varying
    LANGUAGE plpgsql
    AS $$
<< principal >>
DECLARE

-- registros de trabajo

 reg_in_smartpoketotal "smartpoke".rw_smartpoketotal%ROWTYPE;
 reg_limit_smartpoketotal "smartpoke".rw_smartpoketotal%ROWTYPE;
 reg_out_smartpoketotal "smartpoke".rw_smartpoketotal%ROWTYPE;

 w_smartpoketotal "smartpoke".rw_smartpoketotal%ROWTYPE;

-- variables de trabajo

 w_retorno int;

BEGIN

    w_smartpoketotal.spot_id := p_spot_id;
	w_smartpoketotal.acctdate := p_acctdate;
	w_smartpoketotal.pos := 'TOTAL';
	w_smartpoketotal.sensorname := p_sensorname;
	w_smartpoketotal.callingstationid := p_callingstationid;
	w_smartpoketotal.brand := p_brand;

   -- Lo primero que hago es intentar leer los registros de 'IN', 'LIMIT', 'OUT'
   BEGIN
     	select * into strict reg_in_smartpoketotal
		   from "smartpoke".rw_smartpoketotal
		  where spot_id = w_smartpoketotal.spot_id and
		        acctdate = w_smartpoketotal.acctdate and
		        pos = 'IN' and
			    sensorname = w_smartpoketotal.sensorname and
			    callingstationid = w_smartpoketotal.callingstationid ;
   EXCEPTION
     WHEN NO_DATA_FOUND THEN
	    null;
  	WHEN OTHERS THEN
		RETURN  'Error '||SQLSTATE||' en la linea de total';
   END;
   BEGIN
    	select * into strict reg_limit_smartpoketotal
		   from "smartpoke".rw_smartpoketotal
		  where spot_id = w_smartpoketotal.spot_id and
		        acctdate = w_smartpoketotal.acctdate and
		        pos = 'LIMIT' and
			    sensorname = w_smartpoketotal.sensorname and
			    callingstationid = w_smartpoketotal.callingstationid ;
   EXCEPTION
     WHEN NO_DATA_FOUND THEN
	    null;
  	WHEN OTHERS THEN
		RETURN  'Error '||SQLSTATE||' en la linea de total';
   END;
     BEGIN
    	select * into strict reg_out_smartpoketotal
		   from "smartpoke".rw_smartpoketotal
		  where spot_id = w_smartpoketotal.spot_id and
		        acctdate = w_smartpoketotal.acctdate and
		        pos = 'OUT' and
			    sensorname = w_smartpoketotal.sensorname and
			    callingstationid = w_smartpoketotal.callingstationid ;
  EXCEPTION
     WHEN NO_DATA_FOUND THEN
	    null;
  	WHEN OTHERS THEN
		RETURN  'Error '||SQLSTATE||' en la linea de total';
   END;

     -- Actualizo las columnas de totales de acuerdo al criterio de si hay valor en IN prevalece sobre el resto y el de LIMIT sobre el de OUT

	Case
	 when COALESCE(reg_in_smartpoketotal.tim00,0) > 0 then
	   w_smartpoketotal.tim00 := COALESCE(reg_in_smartpoketotal.tim00,0);
	   w_smartpoketotal.num00 := COALESCE(reg_in_smartpoketotal.num00,0);
	 when COALESCE(reg_limit_smartpoketotal.tim00,0) > 0 then
	   w_smartpoketotal.tim00 := COALESCE(reg_limit_smartpoketotal.tim00,0);
	   w_smartpoketotal.num00 := COALESCE(reg_limit_smartpoketotal.num00,0);
	else
	   w_smartpoketotal.tim00 := COALESCE(reg_out_smartpoketotal.tim00,0);
	   w_smartpoketotal.num00 := COALESCE(reg_out_smartpoketotal.num00,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim01,0) > 0 then
	   w_smartpoketotal.tim01 := COALESCE(reg_in_smartpoketotal.tim01,0);
	   w_smartpoketotal.num01 := COALESCE(reg_in_smartpoketotal.num01,0);
	 when COALESCE(reg_limit_smartpoketotal.tim01,0) > 0 then
	   w_smartpoketotal.tim01 := COALESCE(reg_limit_smartpoketotal.tim01,0);
	   w_smartpoketotal.num01 := COALESCE(reg_limit_smartpoketotal.num01,0);
	else
	   w_smartpoketotal.tim01 := COALESCE(reg_out_smartpoketotal.tim01,0);
	   w_smartpoketotal.num01 := COALESCE(reg_out_smartpoketotal.num01,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim02,0) > 0 then
	   w_smartpoketotal.tim02 := COALESCE(reg_in_smartpoketotal.tim02,0);
	   w_smartpoketotal.num02 := COALESCE(reg_in_smartpoketotal.num02,0);
	 when COALESCE(reg_limit_smartpoketotal.tim02,0) > 0 then
	   w_smartpoketotal.tim02 := COALESCE(reg_limit_smartpoketotal.tim02,0);
	   w_smartpoketotal.num02 := COALESCE(reg_limit_smartpoketotal.num02,0);
	else
	   w_smartpoketotal.tim02 := COALESCE(reg_out_smartpoketotal.tim02,0);
	   w_smartpoketotal.num02 := COALESCE(reg_out_smartpoketotal.num02,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim03,0) > 0 then
	   w_smartpoketotal.tim03 := COALESCE(reg_in_smartpoketotal.tim03,0);
	   w_smartpoketotal.num03 := COALESCE(reg_in_smartpoketotal.num03,0);
	 when COALESCE(reg_limit_smartpoketotal.tim03,0) > 0 then
	   w_smartpoketotal.tim03 := COALESCE(reg_limit_smartpoketotal.tim03,0);
	   w_smartpoketotal.num03 := COALESCE(reg_limit_smartpoketotal.num03,0);
	else
	   w_smartpoketotal.tim03 := COALESCE(reg_out_smartpoketotal.tim03,0);
	   w_smartpoketotal.num03 := COALESCE(reg_out_smartpoketotal.num03,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim04,0) > 0 then
	   w_smartpoketotal.tim04 := COALESCE(reg_in_smartpoketotal.tim04,0);
	   w_smartpoketotal.num04 := COALESCE(reg_in_smartpoketotal.num04,0);
	 when COALESCE(reg_limit_smartpoketotal.tim04,0) > 0 then
	   w_smartpoketotal.tim04 := COALESCE(reg_limit_smartpoketotal.tim04,0);
	   w_smartpoketotal.num04 := COALESCE(reg_limit_smartpoketotal.num04,0);
	else
	   w_smartpoketotal.tim04 := COALESCE(reg_out_smartpoketotal.tim04,0);
	   w_smartpoketotal.num04 := COALESCE(reg_out_smartpoketotal.num04,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim05,0) > 0 then
	   w_smartpoketotal.tim05 := COALESCE(reg_in_smartpoketotal.tim05,0);
	   w_smartpoketotal.num05 := COALESCE(reg_in_smartpoketotal.num05,0);
	 when COALESCE(reg_limit_smartpoketotal.tim05,0) > 0 then
	   w_smartpoketotal.tim05 := COALESCE(reg_limit_smartpoketotal.tim05,0);
	   w_smartpoketotal.num05 := COALESCE(reg_limit_smartpoketotal.num05,0);
	else
	   w_smartpoketotal.tim05 := COALESCE(reg_out_smartpoketotal.tim05,0);
	   w_smartpoketotal.num05 := COALESCE(reg_out_smartpoketotal.num05,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim06,0) > 0 then
	   w_smartpoketotal.tim06 := COALESCE(reg_in_smartpoketotal.tim06,0);
	   w_smartpoketotal.num06 := COALESCE(reg_in_smartpoketotal.num06,0);
	 when COALESCE(reg_limit_smartpoketotal.tim06,0) > 0 then
	   w_smartpoketotal.tim06 := COALESCE(reg_limit_smartpoketotal.tim06,0);
	   w_smartpoketotal.num06 := COALESCE(reg_limit_smartpoketotal.num06,0);
	else
	   w_smartpoketotal.tim06 := COALESCE(reg_out_smartpoketotal.tim06,0);
	   w_smartpoketotal.num06 := COALESCE(reg_out_smartpoketotal.num06,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim07,0) > 0 then
	   w_smartpoketotal.tim07 := COALESCE(reg_in_smartpoketotal.tim07,0);
	   w_smartpoketotal.num07 := COALESCE(reg_in_smartpoketotal.num07,0);
	 when COALESCE(reg_limit_smartpoketotal.tim07,0) > 0 then
	   w_smartpoketotal.tim07 := COALESCE(reg_limit_smartpoketotal.tim07,0);
	   w_smartpoketotal.num07 := COALESCE(reg_limit_smartpoketotal.num07,0);
	else
	   w_smartpoketotal.tim07 := COALESCE(reg_out_smartpoketotal.tim07,0);
	   w_smartpoketotal.num07 := COALESCE(reg_out_smartpoketotal.num07,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim08,0) > 0 then
	   w_smartpoketotal.tim08 := COALESCE(reg_in_smartpoketotal.tim08,0);
	   w_smartpoketotal.num08 := COALESCE(reg_in_smartpoketotal.num08,0);
	 when COALESCE(reg_limit_smartpoketotal.tim08,0) > 0 then
	   w_smartpoketotal.tim08 := COALESCE(reg_limit_smartpoketotal.tim08,0);
	   w_smartpoketotal.num08 := COALESCE(reg_limit_smartpoketotal.num08,0);
	else
	   w_smartpoketotal.tim08 := COALESCE(reg_out_smartpoketotal.tim08,0);
	   w_smartpoketotal.num08 := COALESCE(reg_out_smartpoketotal.num08,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim09,0) > 0 then
	   w_smartpoketotal.tim09 := COALESCE(reg_in_smartpoketotal.tim09,0);
	   w_smartpoketotal.num09 := COALESCE(reg_in_smartpoketotal.num09,0);
	 when COALESCE(reg_limit_smartpoketotal.tim09,0) > 0 then
	   w_smartpoketotal.tim09 := COALESCE(reg_limit_smartpoketotal.tim09,0);
	   w_smartpoketotal.num09 := COALESCE(reg_limit_smartpoketotal.num09,0);
	else
	   w_smartpoketotal.tim09 := COALESCE(reg_out_smartpoketotal.tim09,0);
	   w_smartpoketotal.num09 := COALESCE(reg_out_smartpoketotal.num09,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim10,0) > 0 then
	   w_smartpoketotal.tim10 := COALESCE(reg_in_smartpoketotal.tim10,0);
	   w_smartpoketotal.num10 := COALESCE(reg_in_smartpoketotal.num10,0);
	 when COALESCE(reg_limit_smartpoketotal.tim10,0) > 0 then
	   w_smartpoketotal.tim10 := COALESCE(reg_limit_smartpoketotal.tim10,0);
	   w_smartpoketotal.num10 := COALESCE(reg_limit_smartpoketotal.num10,0);
	else
	   w_smartpoketotal.tim10 := COALESCE(reg_out_smartpoketotal.tim10,0);
	   w_smartpoketotal.num10 := COALESCE(reg_out_smartpoketotal.num10,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim11,0) > 0 then
	   w_smartpoketotal.tim11 := COALESCE(reg_in_smartpoketotal.tim11,0);
	   w_smartpoketotal.num11 := COALESCE(reg_in_smartpoketotal.num11,0);
	 when COALESCE(reg_limit_smartpoketotal.tim11,0) > 0 then
	   w_smartpoketotal.tim11 := COALESCE(reg_limit_smartpoketotal.tim11,0);
	   w_smartpoketotal.num11 := COALESCE(reg_limit_smartpoketotal.num11,0);
	else
	   w_smartpoketotal.tim11 := COALESCE(reg_out_smartpoketotal.tim11,0);
	   w_smartpoketotal.num11 := COALESCE(reg_out_smartpoketotal.num11,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim12,0) > 0 then
	   w_smartpoketotal.tim12 := COALESCE(reg_in_smartpoketotal.tim12,0);
	   w_smartpoketotal.num12 := COALESCE(reg_in_smartpoketotal.num12,0);
	 when COALESCE(reg_limit_smartpoketotal.tim12,0) > 0 then
	   w_smartpoketotal.tim12 := COALESCE(reg_limit_smartpoketotal.tim12,0);
	   w_smartpoketotal.num12 := COALESCE(reg_limit_smartpoketotal.num12,0);
	else
	   w_smartpoketotal.tim12 := COALESCE(reg_out_smartpoketotal.tim12,0);
	   w_smartpoketotal.num12 := COALESCE(reg_out_smartpoketotal.num12,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim13,0) > 0 then
	   w_smartpoketotal.tim13 := COALESCE(reg_in_smartpoketotal.tim13,0);
	   w_smartpoketotal.num13 := COALESCE(reg_in_smartpoketotal.num13,0);
	 when COALESCE(reg_limit_smartpoketotal.tim13,0) > 0 then
	   w_smartpoketotal.tim13 := COALESCE(reg_limit_smartpoketotal.tim13,0);
	   w_smartpoketotal.num13 := COALESCE(reg_limit_smartpoketotal.num13,0);
	else
	   w_smartpoketotal.tim13 := COALESCE(reg_out_smartpoketotal.tim13,0);
	   w_smartpoketotal.num13 := COALESCE(reg_out_smartpoketotal.num13,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim14,0) > 0 then
	   w_smartpoketotal.tim14 := COALESCE(reg_in_smartpoketotal.tim14,0);
	   w_smartpoketotal.num14 := COALESCE(reg_in_smartpoketotal.num14,0);
	 when COALESCE(reg_limit_smartpoketotal.tim14,0) > 0 then
	   w_smartpoketotal.tim14 := COALESCE(reg_limit_smartpoketotal.tim14,0);
	   w_smartpoketotal.num14 := COALESCE(reg_limit_smartpoketotal.num14,0);
	else
	   w_smartpoketotal.tim14 := COALESCE(reg_out_smartpoketotal.tim14,0);
	   w_smartpoketotal.num14 := COALESCE(reg_out_smartpoketotal.num14,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim15,0) > 0 then
	   w_smartpoketotal.tim15 := COALESCE(reg_in_smartpoketotal.tim15,0);
	   w_smartpoketotal.num15 := COALESCE(reg_in_smartpoketotal.num15,0);
	 when COALESCE(reg_limit_smartpoketotal.tim15,0) > 0 then
	   w_smartpoketotal.tim15 := COALESCE(reg_limit_smartpoketotal.tim15,0);
	   w_smartpoketotal.num15 := COALESCE(reg_limit_smartpoketotal.num15,0);
	else
	   w_smartpoketotal.tim15 := COALESCE(reg_out_smartpoketotal.tim15,0);
	   w_smartpoketotal.num15 := COALESCE(reg_out_smartpoketotal.num15,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim16,0) > 0 then
	   w_smartpoketotal.tim16 := COALESCE(reg_in_smartpoketotal.tim16,0);
	   w_smartpoketotal.num16 := COALESCE(reg_in_smartpoketotal.num16,0);
	 when COALESCE(reg_limit_smartpoketotal.tim16,0) > 0 then
	   w_smartpoketotal.tim16 := COALESCE(reg_limit_smartpoketotal.tim16,0);
	   w_smartpoketotal.num16 := COALESCE(reg_limit_smartpoketotal.num16,0);
	else
	   w_smartpoketotal.tim16 := COALESCE(reg_out_smartpoketotal.tim16,0);
	   w_smartpoketotal.num16 := COALESCE(reg_out_smartpoketotal.num16,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim17,0) > 0 then
	   w_smartpoketotal.tim17 := COALESCE(reg_in_smartpoketotal.tim17,0);
	   w_smartpoketotal.num17 := COALESCE(reg_in_smartpoketotal.num17,0);
	 when COALESCE(reg_limit_smartpoketotal.tim17,0) > 0 then
	   w_smartpoketotal.tim17 := COALESCE(reg_limit_smartpoketotal.tim17,0);
	   w_smartpoketotal.num17 := COALESCE(reg_limit_smartpoketotal.num17,0);
	else
	   w_smartpoketotal.tim17 := COALESCE(reg_out_smartpoketotal.tim17,0);
	   w_smartpoketotal.num17 := COALESCE(reg_out_smartpoketotal.num17,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim18,0) > 0 then
	   w_smartpoketotal.tim18 := COALESCE(reg_in_smartpoketotal.tim18,0);
	   w_smartpoketotal.num18 := COALESCE(reg_in_smartpoketotal.num18,0);
	 when COALESCE(reg_limit_smartpoketotal.tim18,0) > 0 then
	   w_smartpoketotal.tim18 := COALESCE(reg_limit_smartpoketotal.tim18,0);
	   w_smartpoketotal.num18 := COALESCE(reg_limit_smartpoketotal.num18,0);
	else
	   w_smartpoketotal.tim18 := COALESCE(reg_out_smartpoketotal.tim18,0);
	   w_smartpoketotal.num18 := COALESCE(reg_out_smartpoketotal.num18,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim19,0) > 0 then
	   w_smartpoketotal.tim19 := COALESCE(reg_in_smartpoketotal.tim19,0);
	   w_smartpoketotal.num19 := COALESCE(reg_in_smartpoketotal.num19,0);
	 when COALESCE(reg_limit_smartpoketotal.tim19,0) > 0 then
	   w_smartpoketotal.tim19 := COALESCE(reg_limit_smartpoketotal.tim19,0);
	   w_smartpoketotal.num19 := COALESCE(reg_limit_smartpoketotal.num19,0);
	else
	   w_smartpoketotal.tim19 := COALESCE(reg_out_smartpoketotal.tim19,0);
	   w_smartpoketotal.num19 := COALESCE(reg_out_smartpoketotal.num19,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim20,0) > 0 then
	   w_smartpoketotal.tim20 := COALESCE(reg_in_smartpoketotal.tim20,0);
	   w_smartpoketotal.num20 := COALESCE(reg_in_smartpoketotal.num20,0);
	 when COALESCE(reg_limit_smartpoketotal.tim20,0) > 0 then
	   w_smartpoketotal.tim20 := COALESCE(reg_limit_smartpoketotal.tim20,0);
	   w_smartpoketotal.num20 := COALESCE(reg_limit_smartpoketotal.num20,0);
	else
	   w_smartpoketotal.tim20 := COALESCE(reg_out_smartpoketotal.tim20,0);
	   w_smartpoketotal.num20 := COALESCE(reg_out_smartpoketotal.num20,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim21,0) > 0 then
	   w_smartpoketotal.tim21 := COALESCE(reg_in_smartpoketotal.tim21,0);
	   w_smartpoketotal.num21 := COALESCE(reg_in_smartpoketotal.num21,0);
	 when COALESCE(reg_limit_smartpoketotal.tim21,0) > 0 then
	   w_smartpoketotal.tim21 := COALESCE(reg_limit_smartpoketotal.tim21,0);
	   w_smartpoketotal.num21 := COALESCE(reg_limit_smartpoketotal.num21,0);
	else
	   w_smartpoketotal.tim21 := COALESCE(reg_out_smartpoketotal.tim21,0);
	   w_smartpoketotal.num21 := COALESCE(reg_out_smartpoketotal.num21,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim22,0) > 0 then
	   w_smartpoketotal.tim22 := COALESCE(reg_in_smartpoketotal.tim22,0);
	   w_smartpoketotal.num22 := COALESCE(reg_in_smartpoketotal.num22,0);
	 when COALESCE(reg_limit_smartpoketotal.tim22,0) > 0 then
	   w_smartpoketotal.tim22 := COALESCE(reg_limit_smartpoketotal.tim22,0);
	   w_smartpoketotal.num22 := COALESCE(reg_limit_smartpoketotal.num22,0);
	else
	   w_smartpoketotal.tim22 := COALESCE(reg_out_smartpoketotal.tim22,0);
	   w_smartpoketotal.num22 := COALESCE(reg_out_smartpoketotal.num22,0);
	end case;

	Case
	 when COALESCE(reg_in_smartpoketotal.tim23,0) > 0 then
	   w_smartpoketotal.tim23 := COALESCE(reg_in_smartpoketotal.tim23,0);
	   w_smartpoketotal.num23 := COALESCE(reg_in_smartpoketotal.num23,0);
	 when COALESCE(reg_limit_smartpoketotal.tim23,0) > 0 then
	   w_smartpoketotal.tim23 := COALESCE(reg_limit_smartpoketotal.tim23,0);
	   w_smartpoketotal.num23 := COALESCE(reg_limit_smartpoketotal.num23,0);
	else
	   w_smartpoketotal.tim23 := COALESCE(reg_out_smartpoketotal.tim23,0);
	   w_smartpoketotal.num23 := COALESCE(reg_out_smartpoketotal.num23,0);
	end case;


	-- Con la información actualizada, podemos llamar al proceso de actualizar la tabla
	select "smartpoke".actualizar_smartpoketotal
	    (w_smartpoketotal.spot_id, w_smartpoketotal.acctdate, w_smartpoketotal.pos, w_smartpoketotal.sensorname,
		w_smartpoketotal.callingstationid, w_smartpoketotal.brand,
		w_smartpoketotal.tim00, w_smartpoketotal.num00, w_smartpoketotal.tim01, w_smartpoketotal.num01, w_smartpoketotal.tim02, w_smartpoketotal.num02,
		w_smartpoketotal.tim03, w_smartpoketotal.num03, w_smartpoketotal.tim04, w_smartpoketotal.num04, w_smartpoketotal.tim05, w_smartpoketotal.num05,
		w_smartpoketotal.tim06, w_smartpoketotal.num06, w_smartpoketotal.tim07, w_smartpoketotal.num07, w_smartpoketotal.tim08, w_smartpoketotal.num08,
		w_smartpoketotal.tim09, w_smartpoketotal.num09, w_smartpoketotal.tim10, w_smartpoketotal.num10, w_smartpoketotal.tim11, w_smartpoketotal.num11,
		w_smartpoketotal.tim12, w_smartpoketotal.num12, w_smartpoketotal.tim13, w_smartpoketotal.num13, w_smartpoketotal.tim14, w_smartpoketotal.num14,
		w_smartpoketotal.tim15, w_smartpoketotal.num15, w_smartpoketotal.tim16, w_smartpoketotal.num16, w_smartpoketotal.tim17, w_smartpoketotal.num17,
		w_smartpoketotal.tim18, w_smartpoketotal.num18, w_smartpoketotal.tim19, w_smartpoketotal.num19, w_smartpoketotal.tim20, w_smartpoketotal.num20,
		w_smartpoketotal.tim21, w_smartpoketotal.num21, w_smartpoketotal.tim22, w_smartpoketotal.num22, w_smartpoketotal.tim23, w_smartpoketotal.num23
		)
	    into w_retorno;


   RETURN 'OK';
EXCEPTION
  WHEN OTHERS THEN
	RETURN  'Error '||SQLSTATE||' en la linea de total';

END;

$$;


ALTER FUNCTION smartpoke.actualizar_linea_total_smartpoketotal(p_spot_id character varying, p_acctdate date, p_sensorname character varying, p_callingstationid character varying, p_brand character varying) OWNER TO esmartitpg;

--
-- TOC entry 270 (class 1255 OID 17841)
-- Name: actualizar_sensortotal(character varying, date, character varying, character varying, character varying, character varying, character varying, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, boolean); Type: FUNCTION; Schema: smartpoke; Owner: esmartitpg
--

CREATE FUNCTION smartpoke.actualizar_sensortotal(p_spot_id character varying, p_acctdate date, p_pos character varying, p_sensorname character varying, p_devicemac character varying, p_devicehashmac character varying, p_brand character varying, p_tim00 bigint, p_num00 bigint, p_tim01 bigint, p_num01 bigint, p_tim02 bigint, p_num02 bigint, p_tim03 bigint, p_num03 bigint, p_tim04 bigint, p_num04 bigint, p_tim05 bigint, p_num05 bigint, p_tim06 bigint, p_num06 bigint, p_tim07 bigint, p_num07 bigint, p_tim08 bigint, p_num08 bigint, p_tim09 bigint, p_num09 bigint, p_tim10 bigint, p_num10 bigint, p_tim11 bigint, p_num11 bigint, p_tim12 bigint, p_num12 bigint, p_tim13 bigint, p_num13 bigint, p_tim14 bigint, p_num14 bigint, p_tim15 bigint, p_num15 bigint, p_tim16 bigint, p_num16 bigint, p_tim17 bigint, p_num17 bigint, p_tim18 bigint, p_num18 bigint, p_tim19 bigint, p_num19 bigint, p_tim20 bigint, p_num20 bigint, p_tim21 bigint, p_num21 bigint, p_tim22 bigint, p_num22 bigint, p_tim23 bigint, p_num23 bigint, p_exis boolean) RETURNS integer
    LANGUAGE plpgsql
    AS $$
<< principal >>
DECLARE

-- registros de trabajo
 reg_sensortotal "smartpoke".rw_sensortotal%ROWTYPE;

BEGIN
     -- Calculo el valor del total de la línea
	 reg_sensortotal.timto :=
					COALESCE(p_tim00,0) + COALESCE(p_tim01,0) + COALESCE(p_tim02,0) + COALESCE(p_tim03,0) + COALESCE(p_tim04,0) +
					COALESCE(p_tim05,0) + COALESCE(p_tim06,0) + COALESCE(p_tim07,0) + COALESCE(p_tim08,0) + COALESCE(p_tim09,0) +
					COALESCE(p_tim10,0) + COALESCE(p_tim11,0) + COALESCE(p_tim12,0) + COALESCE(p_tim13,0) + COALESCE(p_tim14,0) +
					COALESCE(p_tim15,0) + COALESCE(p_tim16,0) + COALESCE(p_tim17,0) + COALESCE(p_tim18,0) + COALESCE(p_tim19,0) +
					COALESCE(p_tim20,0) + COALESCE(p_tim21,0) + COALESCE(p_tim22,0) + COALESCE(p_tim23,0);
	 reg_sensortotal.numto := 1;

     -- Si existe el registro lo modifico, sino lo inserto
	 if p_exis
	 then
			UPDATE "smartpoke".rw_sensortotal
				SET brand = p_brand,
				    tim00 = p_tim00, num00 = p_num00, tim01 = p_tim01, num01 = p_num01,
				    tim02 = p_tim02, num02 = p_num02, tim03 = p_tim03, num03 = p_num03,
				    tim04 = p_tim04, num04 = p_num04, tim05 = p_tim05, num05 = p_num05,
					tim06 = p_tim06, num06 = p_num06,
				    tim07 = p_tim07, num07 = p_num07, tim08 = p_tim08, num08 = p_num08,
				    tim09 = p_tim09, num09 = p_num09, tim10 = p_tim10, num10 = p_num10,
				    tim11 = p_tim11, num11 = p_num11, tim12 = p_tim12, num12 = p_num12,
				    tim13 = p_tim13, num13 = p_num13, tim14 = p_tim14, num14 = p_num14,
				    tim15 = p_tim15, num15 = p_num15, tim16 = p_tim16, num16 = p_num16,
				    tim17 = p_tim17, num17 = p_num17, tim18 = p_tim18, num18 = p_num18,
				    tim19 = p_tim19, num19 = p_num19, tim20 = p_tim20, num20 = p_num20,
				    tim21 = p_tim21, num21 = p_num21, tim22 = p_tim22, num22 = p_num22,
				    tim23 = p_tim23, num23 = p_num23, timto = reg_sensortotal.timto, numto = reg_sensortotal.numto
				WHERE  spot_id = p_spot_id and
				       acctdate = p_acctdate and
					   pos = p_pos and
					   sensorname = p_sensorname and
					   devicemac = p_devicemac and
					   devicehashmac = p_devicehashmac;
	 else
	        INSERT INTO "smartpoke".rw_sensortotal(
					spot_id, acctdate, pos, sensorname, devicemac, devicehashmac, brand,
					tim00, num00, tim01, num01, tim02, num02, tim03, num03, tim04, num04, tim05, num05, tim06, num06, tim07, num07, tim08, num08,
					tim09, num09, tim10, num10, tim11, num11, tim12, num12, tim13, num13, tim14, num14, tim15, num15, tim16, num16, tim17, num17,
					tim18, num18, tim19, num19, tim20, num20, tim21, num21, tim22, num22, tim23, num23, timto, numto)
			 VALUES (p_spot_id, p_acctdate, p_pos, p_sensorname,
			        p_devicemac, p_devicehashmac, p_brand,
					COALESCE(p_tim00,0), COALESCE(p_num00,0), COALESCE(p_tim01,0), COALESCE(p_num01,0), COALESCE(p_tim02,0), COALESCE(p_num02,0),
					COALESCE(p_tim03,0), COALESCE(p_num03,0), COALESCE(p_tim04,0), COALESCE(p_num04,0), COALESCE(p_tim05,0), COALESCE(p_num05,0),
					COALESCE(p_tim06,0), COALESCE(p_num06,0), COALESCE(p_tim07,0), COALESCE(p_num07,0), COALESCE(p_tim08,0), COALESCE(p_num08,0),
					COALESCE(p_tim09,0), COALESCE(p_num09,0), COALESCE(p_tim10,0), COALESCE(p_num10,0), COALESCE(p_tim11,0), COALESCE(p_num11,0),
					COALESCE(p_tim12,0), COALESCE(p_num12,0), COALESCE(p_tim13,0), COALESCE(p_num13,0), COALESCE(p_tim14,0), COALESCE(p_num14,0),
					COALESCE(p_tim15,0), COALESCE(p_num15,0), COALESCE(p_tim16,0), COALESCE(p_num16,0), COALESCE(p_tim17,0), COALESCE(p_num17,0),
					COALESCE(p_tim18,0), COALESCE(p_num18,0), COALESCE(p_tim19,0), COALESCE(p_num19,0), COALESCE(p_tim20,0), COALESCE(p_num20,0),
					COALESCE(p_tim21,0), COALESCE(p_num21,0), COALESCE(p_tim22,0), COALESCE(p_num22,0), COALESCE(p_tim23,0), COALESCE(p_num23,0),
					reg_sensortotal.timto, reg_sensortotal.numto);
	 end if;
	 return 0;
END;

$$;


ALTER FUNCTION smartpoke.actualizar_sensortotal(p_spot_id character varying, p_acctdate date, p_pos character varying, p_sensorname character varying, p_devicemac character varying, p_devicehashmac character varying, p_brand character varying, p_tim00 bigint, p_num00 bigint, p_tim01 bigint, p_num01 bigint, p_tim02 bigint, p_num02 bigint, p_tim03 bigint, p_num03 bigint, p_tim04 bigint, p_num04 bigint, p_tim05 bigint, p_num05 bigint, p_tim06 bigint, p_num06 bigint, p_tim07 bigint, p_num07 bigint, p_tim08 bigint, p_num08 bigint, p_tim09 bigint, p_num09 bigint, p_tim10 bigint, p_num10 bigint, p_tim11 bigint, p_num11 bigint, p_tim12 bigint, p_num12 bigint, p_tim13 bigint, p_num13 bigint, p_tim14 bigint, p_num14 bigint, p_tim15 bigint, p_num15 bigint, p_tim16 bigint, p_num16 bigint, p_tim17 bigint, p_num17 bigint, p_tim18 bigint, p_num18 bigint, p_tim19 bigint, p_num19 bigint, p_tim20 bigint, p_num20 bigint, p_tim21 bigint, p_num21 bigint, p_tim22 bigint, p_num22 bigint, p_tim23 bigint, p_num23 bigint, p_exis boolean) OWNER TO esmartitpg;

--
-- TOC entry 271 (class 1255 OID 17842)
-- Name: actualizar_smartpoketotal(character varying, date, character varying, character varying, character varying, character varying, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint, bigint); Type: FUNCTION; Schema: smartpoke; Owner: esmartitpg
--

CREATE FUNCTION smartpoke.actualizar_smartpoketotal(p_spot_id character varying, p_acctdate date, p_pos character varying, p_sensorname character varying, p_callingstationid character varying, p_brand character varying, p_tim00 bigint, p_num00 bigint, p_tim01 bigint, p_num01 bigint, p_tim02 bigint, p_num02 bigint, p_tim03 bigint, p_num03 bigint, p_tim04 bigint, p_num04 bigint, p_tim05 bigint, p_num05 bigint, p_tim06 bigint, p_num06 bigint, p_tim07 bigint, p_num07 bigint, p_tim08 bigint, p_num08 bigint, p_tim09 bigint, p_num09 bigint, p_tim10 bigint, p_num10 bigint, p_tim11 bigint, p_num11 bigint, p_tim12 bigint, p_num12 bigint, p_tim13 bigint, p_num13 bigint, p_tim14 bigint, p_num14 bigint, p_tim15 bigint, p_num15 bigint, p_tim16 bigint, p_num16 bigint, p_tim17 bigint, p_num17 bigint, p_tim18 bigint, p_num18 bigint, p_tim19 bigint, p_num19 bigint, p_tim20 bigint, p_num20 bigint, p_tim21 bigint, p_num21 bigint, p_tim22 bigint, p_num22 bigint, p_tim23 bigint, p_num23 bigint) RETURNS integer
    LANGUAGE plpgsql
    AS $$
<< principal >>
DECLARE

-- registros de trabajo
 reg_smartpoketotal "smartpoke".rw_smartpoketotal%ROWTYPE;

 w_count int2 := 0;

BEGIN
     -- Calculo el valor del total de la línea
	 reg_smartpoketotal.timto :=
					COALESCE(p_tim00,0) + COALESCE(p_tim01,0) + COALESCE(p_tim02,0) + COALESCE(p_tim03,0) + COALESCE(p_tim04,0) +
					COALESCE(p_tim05,0) + COALESCE(p_tim06,0) + COALESCE(p_tim07,0) + COALESCE(p_tim08,0) + COALESCE(p_tim09,0) +
					COALESCE(p_tim10,0) + COALESCE(p_tim11,0) + COALESCE(p_tim12,0) + COALESCE(p_tim13,0) + COALESCE(p_tim14,0) +
					COALESCE(p_tim15,0) + COALESCE(p_tim16,0) + COALESCE(p_tim17,0) + COALESCE(p_tim18,0) + COALESCE(p_tim19,0) +
					COALESCE(p_tim20,0) + COALESCE(p_tim21,0) + COALESCE(p_tim22,0) + COALESCE(p_tim23,0);
	 reg_smartpoketotal.numto := 1;

	    -- Compruebo si ya existe la línea de totales para su actualización o inserción
    select count(*) into w_count
	   from "smartpoke".rw_smartpoketotal
	   where spot_id = p_spot_id and
	        acctdate = p_acctdate and
	        pos = p_pos and
		    sensorname = p_sensorname and
		    callingstationid = p_callingstationid;


    if w_count = 0
    then
	  -- No existe, luego inserto
	        INSERT INTO "smartpoke".rw_smartpoketotal(
					spot_id, acctdate, pos, sensorname, callingstationid, brand,
					tim00, num00, tim01, num01, tim02, num02, tim03, num03, tim04, num04, tim05, num05, tim06, num06, tim07, num07, tim08, num08,
					tim09, num09, tim10, num10, tim11, num11, tim12, num12, tim13, num13, tim14, num14, tim15, num15, tim16, num16, tim17, num17,
					tim18, num18, tim19, num19, tim20, num20, tim21, num21, tim22, num22, tim23, num23, timto, numto)
			 VALUES (p_spot_id, p_acctdate, p_pos, p_sensorname,
			        p_callingstationid, p_brand,
					COALESCE(p_tim00,0), COALESCE(p_num00,0), COALESCE(p_tim01,0), COALESCE(p_num01,0), COALESCE(p_tim02,0), COALESCE(p_num02,0),
					COALESCE(p_tim03,0), COALESCE(p_num03,0), COALESCE(p_tim04,0), COALESCE(p_num04,0), COALESCE(p_tim05,0), COALESCE(p_num05,0),
					COALESCE(p_tim06,0), COALESCE(p_num06,0), COALESCE(p_tim07,0), COALESCE(p_num07,0), COALESCE(p_tim08,0), COALESCE(p_num08,0),
					COALESCE(p_tim09,0), COALESCE(p_num09,0), COALESCE(p_tim10,0), COALESCE(p_num10,0), COALESCE(p_tim11,0), COALESCE(p_num11,0),
					COALESCE(p_tim12,0), COALESCE(p_num12,0), COALESCE(p_tim13,0), COALESCE(p_num13,0), COALESCE(p_tim14,0), COALESCE(p_num14,0),
					COALESCE(p_tim15,0), COALESCE(p_num15,0), COALESCE(p_tim16,0), COALESCE(p_num16,0), COALESCE(p_tim17,0), COALESCE(p_num17,0),
					COALESCE(p_tim18,0), COALESCE(p_num18,0), COALESCE(p_tim19,0), COALESCE(p_num19,0), COALESCE(p_tim20,0), COALESCE(p_num20,0),
					COALESCE(p_tim21,0), COALESCE(p_num21,0), COALESCE(p_tim22,0), COALESCE(p_num22,0), COALESCE(p_tim23,0), COALESCE(p_num23,0),
					reg_smartpoketotal.timto, reg_smartpoketotal.numto);
	else
	  -- Existe,lo modifico
			UPDATE "smartpoke".rw_smartpoketotal
				SET brand = p_brand,
				    tim00 = p_tim00, num00 = p_num00, tim01 = p_tim01, num01 = p_num01,
				    tim02 = p_tim02, num02 = p_num02, tim03 = p_tim03, num03 = p_num03,
				    tim04 = p_tim04, num04 = p_num04, tim05 = p_tim05, num05 = p_num05,
					tim06 = p_tim06, num06 = p_num06,
				    tim07 = p_tim07, num07 = p_num07, tim08 = p_tim08, num08 = p_num08,
				    tim09 = p_tim09, num09 = p_num09, tim10 = p_tim10, num10 = p_num10,
				    tim11 = p_tim11, num11 = p_num11, tim12 = p_tim12, num12 = p_num12,
				    tim13 = p_tim13, num13 = p_num13, tim14 = p_tim14, num14 = p_num14,
				    tim15 = p_tim15, num15 = p_num15, tim16 = p_tim16, num16 = p_num16,
				    tim17 = p_tim17, num17 = p_num17, tim18 = p_tim18, num18 = p_num18,
				    tim19 = p_tim19, num19 = p_num19, tim20 = p_tim20, num20 = p_num20,
				    tim21 = p_tim21, num21 = p_num21, tim22 = p_tim22, num22 = p_num22,
				    tim23 = p_tim23, num23 = p_num23, timto = reg_smartpoketotal.timto, numto = reg_smartpoketotal.numto
				WHERE  spot_id = p_spot_id and
				       acctdate = p_acctdate and
					   pos = p_pos and
					   sensorname = p_sensorname and
					   callingstationid = p_callingstationid;
    end if;

	return 0;
END;

$$;


ALTER FUNCTION smartpoke.actualizar_smartpoketotal(p_spot_id character varying, p_acctdate date, p_pos character varying, p_sensorname character varying, p_callingstationid character varying, p_brand character varying, p_tim00 bigint, p_num00 bigint, p_tim01 bigint, p_num01 bigint, p_tim02 bigint, p_num02 bigint, p_tim03 bigint, p_num03 bigint, p_tim04 bigint, p_num04 bigint, p_tim05 bigint, p_num05 bigint, p_tim06 bigint, p_num06 bigint, p_tim07 bigint, p_num07 bigint, p_tim08 bigint, p_num08 bigint, p_tim09 bigint, p_num09 bigint, p_tim10 bigint, p_num10 bigint, p_tim11 bigint, p_num11 bigint, p_tim12 bigint, p_num12 bigint, p_tim13 bigint, p_num13 bigint, p_tim14 bigint, p_num14 bigint, p_tim15 bigint, p_num15 bigint, p_tim16 bigint, p_num16 bigint, p_tim17 bigint, p_num17 bigint, p_tim18 bigint, p_num18 bigint, p_tim19 bigint, p_num19 bigint, p_tim20 bigint, p_num20 bigint, p_tim21 bigint, p_num21 bigint, p_tim22 bigint, p_num22 bigint, p_tim23 bigint, p_num23 bigint) OWNER TO esmartitpg;

--
-- TOC entry 272 (class 1255 OID 17844)
-- Name: ins_sensoracct(character varying, character varying, character varying, date, time without time zone, date, time without time zone, bigint, bigint, numeric); Type: FUNCTION; Schema: smartpoke; Owner: esmartitpg
--

CREATE FUNCTION smartpoke.ins_sensoracct(p_sensorname character varying, p_devicemac character varying, p_devicehashmac character varying, p_acctstartdate date, p_acctstarttime time without time zone, p_acctstopdate date, p_acctstoptime time without time zone, p_acctsessiontime bigint, p_acctpower bigint, p_acctdistance numeric, OUT p_result character varying) RETURNS character varying
    LANGUAGE plpgsql
    AS $$<< principal >>
DECLARE
    r_sensor "smartpoke".rw_sensor%rowtype;
	w_count smallint;
	w_providermac "esmartit".rw_providers.providermac%type;
BEGIN
  -- Tomo la información del sensor
    select * into strict r_sensor from "smartpoke".rw_sensor where sensorname=p_sensorname;

  -- Compruebo si existe el proveedor, sino lo creo vacio para que despues se busque.
    w_providermac = substr(p_devicemac,1,8);

    SELECT count(*) into w_count
	FROM "esmartit".rw_providers
	where providermac = w_providermac;

	if w_count = 0
	then
		-- inserto el proveedor
		INSERT INTO "esmartit".rw_providers(providermac)
			VALUES (w_providermac);
	end if;

   -- Realizo el insert en la tabla
   INSERT INTO "smartpoke".rw_sensoracct(
	        spot_id, sensorname, devicemac, devicehashmac,
			acctstartdate, acctstarttime, acctstopdate, acctstoptime, acctsessiontime, acctpower, acctdistance)
	VALUES (r_sensor.spot_id, r_sensor.sensorname, p_devicemac, p_devicehashmac,
			p_acctstartdate, p_acctstarttime, p_acctstopdate, p_acctstoptime, p_acctsessiontime, p_acctpower, p_acctdistance);
   --
    p_result := '0';
EXCEPTION
  WHEN NO_DATA_FOUND THEN
	     p_result :='Sensor no existe';
  WHEN OTHERS THEN
	p_result := SQLSTATE;

END;
$$;


ALTER FUNCTION smartpoke.ins_sensoracct(p_sensorname character varying, p_devicemac character varying, p_devicehashmac character varying, p_acctstartdate date, p_acctstarttime time without time zone, p_acctstopdate date, p_acctstoptime time without time zone, p_acctsessiontime bigint, p_acctpower bigint, p_acctdistance numeric, OUT p_result character varying) OWNER TO esmartitpg;

--
-- TOC entry 274 (class 1255 OID 17846)
-- Name: totalizar(); Type: FUNCTION; Schema: smartpoke; Owner: esmartitpg
--

CREATE FUNCTION smartpoke.totalizar(OUT p_result character varying) RETURNS character varying
    LANGUAGE plpgsql
    AS $$<< principal >>
DECLARE

-- registros de trabajo
 w_sensoracct "smartpoke".rw_sensoracct%ROWTYPE;  -- guardará el registro anterior
 reg_sensoracct "smartpoke".rw_sensoracct%ROWTYPE;  -- guardará el registro actual

 w_sensortotal "smartpoke".rw_sensortotal%ROWTYPE;
 reg_sensortotal "smartpoke".rw_sensortotal%ROWTYPE;

 reg_spot "smartpoke".rw_spot%ROWTYPE;
 r_sensor "smartpoke".rw_sensor%rowtype;

-- variables de trabajo
 w_callingstationid "smartpoke".rw_smartpoketotal.callingstationid%TYPE;

 w_registros int4 :=0;

 w_spot int4 :=0;
 w_sensores int4 :=0;
 w_dispositivos int4 :=0;
 w_totales int4 :=0;

 w_cont_dev int2 := 0;
 w_cont_user int2 := 0;

 w_dev_primero boolean := true;
 w_primero boolean := true;
 w_exis boolean := false;
 w_pendiente boolean := false;
 w_totalizar boolean := false;

 w_retorno int;
 w_result character varying;

 w_pos "smartpoke".rw_sensortotal.pos%TYPE;

-- Declaro el cursor que va a recorrer la tabla sensoracct
 cursor_sensoracct cursor for select * from "smartpoke".rw_sensoracct where managed = 'N'
								order by spot_id, sensorname, devicemac, devicehashmac,
										acctstartdate,acctstarttime,acctpower;

BEGIN
  -- Abro e incio la primera fetch
  open cursor_sensoracct;
  -- Tomo el primer registro
  FETCH cursor_sensoracct into reg_sensoracct;
   -- inicializo el registro de trabajo

  WHILE( FOUND and reg_sensoracct.sensoracctid is not null ) LOOP

-- Tomo los datos necesarios del spot
    select * into strict reg_spot from "smartpoke".rw_spot
          where spot_id = reg_sensoracct.spot_id;

	 w_sensortotal.spot_id = reg_sensoracct.spot_id;

	 w_spot := w_spot+1;

	WHILE (reg_spot.spot_id = reg_sensoracct.spot_id) LOOP

	-- Tratare el grupo de registros del mismo spot_id

	 -- Por cada spot, trato todos sus sensores
     -- Tomo la información del sensor
     select * into strict r_sensor from "smartpoke".rw_sensor where sensorname = reg_sensoracct.sensorname;

	 w_sensortotal.sensorname = reg_sensoracct.sensorname;
	 w_sensores := w_sensores +1;

	 WHILE (r_sensor.sensorname = reg_sensoracct.sensorname) LOOP

	-- Tratare el grupo de registros del mismo sensor

	 -- A continuación tratare los registros del mismo dispositivo

	   w_cont_dev := 0;
		-- Lo primero que hago es comprobar si debo tratar el dispositivo o desecharlo
	   SELECT count(*) into w_cont_dev	FROM "smartpoke".rw_devices
		  WHERE spot_id = reg_sensoracct.spot_id and
				substring(devicemac, 1, 8) = reg_sensoracct.devicemac and
	            devicehashmac = reg_sensoracct.devicehashmac;

	   w_dev_primero := true;
       w_sensoracct := reg_sensoracct;

	   WHILE (w_sensoracct.devicemac = reg_sensoracct.devicemac and
	          w_sensoracct.devicehashmac = reg_sensoracct.devicehashmac) LOOP

		IF w_cont_dev = 0
		THEN
			-- Si no existe lo tengo que tratar y ahora los agrupare por fecha y posición

		  -- Comprobare si el entra dentro del rango de horas a tratar y está dentro del margen del sensor
		  if (reg_sensoracct.acctstarttime >= reg_spot.timestart and
		     reg_sensoracct.acctstoptime <= reg_spot.timestop )
			 and  reg_sensoracct.acctsessiontime > 0
		     and reg_sensoracct.acctpower >= cast(r_sensor.pwr_out as bigint)
		  then

	       w_dispositivos := w_dispositivos+1;

		  -- Si es el primer registro a tratar del dispotivo tomo los datos de la marca
		    if w_dev_primero then
		       w_sensortotal.devicemac = reg_sensoracct.devicemac;
	           w_sensortotal.devicehashmac = reg_sensoracct.devicehashmac;

			   w_dev_primero := false;
	           w_primero := true;
			  BEGIN
			   SELECT brand into strict w_sensortotal.brand
			     FROM esmartit.rw_providers
			     where providermac = substr(reg_sensoracct.devicemac,1,8);

			  EXCEPTION
			    WHEN NO_DATA_FOUND THEN
			     w_sensortotal.brand := 'NO BRAND';
			  END;
      -- Compruebo si es de un usuario identificado, si es así tendre que almacenar los totales de smartpoke
			  w_callingstationid = reg_sensoracct.devicemac||':'||substr(reg_sensoracct.devicehashmac,1,8);
     	      SELECT count(*) into w_cont_user
			     FROM "smartpoke".rs_userdevice
			     where callingstationid = w_callingstationid;

		    end if;


	   -- El registro se debe tratar, compruebo si está 'IN', 'LIMIT' o 'OUT'
	       Case
		     when reg_sensoracct.acctpower >= cast(r_sensor.pwr_in as bigint) then w_pos := 'IN';
			 when reg_sensoracct.acctpower >= cast(r_sensor.pwr_limit as bigint) then w_pos := 'LIMIT';
			 else w_pos := 'OUT';
		   End case;


		   -- Comrpuebo si ha cambiado la posición o la fecha y si tengo que actualizar la información.
		   if w_pendiente and not (w_sensortotal.acctdate = reg_sensoracct.acctstartdate and
                       		       w_sensortotal.pos = w_pos)
		      and not w_primero
		   then
		      w_pendiente := false;
			  w_primero := true;
			  w_totalizar := true;

			  -- Debo actualizar la tabla de totales
			     select "smartpoke".actualizar_sensortotal
				    (w_sensortotal.spot_id, w_sensortotal.acctdate, w_sensortotal.pos, w_sensortotal.sensorname,
					w_sensortotal.devicemac, w_sensortotal.devicehashmac, w_sensortotal.brand,
					w_sensortotal.tim00, w_sensortotal.num00, w_sensortotal.tim01, w_sensortotal.num01, w_sensortotal.tim02, w_sensortotal.num02,
					w_sensortotal.tim03, w_sensortotal.num03, w_sensortotal.tim04, w_sensortotal.num04, w_sensortotal.tim05, w_sensortotal.num05,
					w_sensortotal.tim06, w_sensortotal.num06, w_sensortotal.tim07, w_sensortotal.num07, w_sensortotal.tim08, w_sensortotal.num08,
					w_sensortotal.tim09, w_sensortotal.num09, w_sensortotal.tim10, w_sensortotal.num10, w_sensortotal.tim11, w_sensortotal.num11,
					w_sensortotal.tim12, w_sensortotal.num12, w_sensortotal.tim13, w_sensortotal.num13, w_sensortotal.tim14, w_sensortotal.num14,
					w_sensortotal.tim15, w_sensortotal.num15, w_sensortotal.tim16, w_sensortotal.num16, w_sensortotal.tim17, w_sensortotal.num17,
					w_sensortotal.tim18, w_sensortotal.num18, w_sensortotal.tim19, w_sensortotal.num19, w_sensortotal.tim20, w_sensortotal.num20,
					w_sensortotal.tim21, w_sensortotal.num21, w_sensortotal.tim22, w_sensortotal.num22, w_sensortotal.tim23, w_sensortotal.num23,
					w_exis)
				   into w_retorno;

				 -- Si tiene usuario asociado actualizo los totales de smartpoketotal
				 if w_cont_user > 0 then
					select "smartpoke".actualizar_smartpoketotal
						(w_sensortotal.spot_id, w_sensortotal.acctdate, w_sensortotal.pos, w_sensortotal.sensorname,
						w_callingstationid, w_sensortotal.brand,
						w_sensortotal.tim00, w_sensortotal.num00, w_sensortotal.tim01, w_sensortotal.num01, w_sensortotal.tim02, w_sensortotal.num02,
						w_sensortotal.tim03, w_sensortotal.num03, w_sensortotal.tim04, w_sensortotal.num04, w_sensortotal.tim05, w_sensortotal.num05,
						w_sensortotal.tim06, w_sensortotal.num06, w_sensortotal.tim07, w_sensortotal.num07, w_sensortotal.tim08, w_sensortotal.num08,
						w_sensortotal.tim09, w_sensortotal.num09, w_sensortotal.tim10, w_sensortotal.num10, w_sensortotal.tim11, w_sensortotal.num11,
						w_sensortotal.tim12, w_sensortotal.num12, w_sensortotal.tim13, w_sensortotal.num13, w_sensortotal.tim14, w_sensortotal.num14,
						w_sensortotal.tim15, w_sensortotal.num15, w_sensortotal.tim16, w_sensortotal.num16, w_sensortotal.tim17, w_sensortotal.num17,
						w_sensortotal.tim18, w_sensortotal.num18, w_sensortotal.tim19, w_sensortotal.num19, w_sensortotal.tim20, w_sensortotal.num20,
						w_sensortotal.tim21, w_sensortotal.num21, w_sensortotal.tim22, w_sensortotal.num22, w_sensortotal.tim23, w_sensortotal.num23)
					  into w_retorno;
				 end if;

				   -- Una vez creado el registro debo inicializar los totales
				    w_sensortotal.tim00 := 0;
				    w_sensortotal.num00 := 0;
				    w_sensortotal.tim01 := 0;
				    w_sensortotal.num01 := 0;
				    w_sensortotal.tim02 := 0;
				    w_sensortotal.num02 := 0;
					w_sensortotal.tim03 := 0;
				    w_sensortotal.num03 := 0;
				    w_sensortotal.tim04 := 0;
				    w_sensortotal.num04 := 0;
				    w_sensortotal.tim05 := 0;
				    w_sensortotal.num05 := 0;
					w_sensortotal.tim06 := 0;
				    w_sensortotal.num06 := 0;
				    w_sensortotal.tim07 := 0;
				    w_sensortotal.num07 := 0;
				    w_sensortotal.tim08 := 0;
				    w_sensortotal.num08 := 0;
					w_sensortotal.tim09 := 0;
				    w_sensortotal.num09 := 0;
				    w_sensortotal.tim10 := 0;
				    w_sensortotal.num10 := 0;
				    w_sensortotal.tim11 := 0;
				    w_sensortotal.num11 := 0;
					w_sensortotal.tim12 := 0;
				    w_sensortotal.num12 := 0;
				    w_sensortotal.tim13 := 0;
				    w_sensortotal.num13 := 0;
				    w_sensortotal.tim14 := 0;
				    w_sensortotal.num14 := 0;
					w_sensortotal.tim15 := 0;
				    w_sensortotal.num15 := 0;
				    w_sensortotal.tim16 := 0;
				    w_sensortotal.num16 := 0;
				    w_sensortotal.tim17 := 0;
				    w_sensortotal.num17 := 0;
					w_sensortotal.tim18 := 0;
				    w_sensortotal.num18 := 0;
				    w_sensortotal.tim19 := 0;
				    w_sensortotal.num19 := 0;
				    w_sensortotal.tim20 := 0;
				    w_sensortotal.num20 := 0;
					w_sensortotal.tim21 := 0;
				    w_sensortotal.num21 := 0;
				    w_sensortotal.tim22 := 0;
				    w_sensortotal.num22 := 0;
				    w_sensortotal.tim23 := 0;
				    w_sensortotal.num23 := 0;

			  -- Debo actualizar la línea de totales para ese díspositivo y día si lo que cambia es el día
			    if w_sensortotal.acctdate <> reg_sensoracct.acctstartdate
				then
				   select "smartpoke".actualizar_linea_total_sensortotal
						(w_sensortotal.spot_id, w_sensortotal.acctdate, w_sensortotal.sensorname,
						 w_sensortotal.devicemac, w_sensortotal.devicehashmac, w_sensortotal.brand
						 )
					into w_result;
					if w_result <> 'OK'
					then
					   RAISE EXCEPTION 'Error en la linea de Totales %', w_result;
					end if;

				 -- Si tiene usuario asociado actualizo la línea de totales de smartpoketotal
				 if w_cont_user > 0 then
				   select "smartpoke".actualizar_linea_total_smartpoketotal
						(w_sensortotal.spot_id, w_sensortotal.acctdate, w_sensortotal.sensorname,
						 w_callingstationid, w_sensortotal.brand
						 )
					into w_result;
					if w_result <> 'OK'
					then
					   RAISE EXCEPTION 'Error en la linea de Totales de smartpoketotal %', w_result;
					end if;
				 end if;

			       w_totalizar := false;
			    end if;
			  w_totales := w_totales+1;
		   end if;

		   -- Si es el primer registro de esa fecha y esa posición leo actualizo valores
		   if w_primero then

		      w_sensortotal.acctdate := reg_sensoracct.acctstartdate;
			  w_sensortotal.pos := w_pos;
			  w_primero := false;
			  -- Compruebo si ya hay entrada para ese día, dispositivo y posición
			  BEGIN
			   select * into strict reg_sensortotal
			     from "smartpoke".rw_sensortotal
				 where spot_id = w_sensortotal.spot_id and
				       acctdate = w_sensortotal.acctdate and
					   pos = w_sensortotal.pos and
					   sensorname = w_sensortotal.sensorname and
					   devicemac = w_sensortotal.devicemac and
					   devicehashmac = w_sensortotal.devicehashmac;

				  -- Actualizo los datos de trabajo con los de la BBDD
				   w_sensortotal := reg_sensortotal;
				   w_exis := true;
			   EXCEPTION
			     WHEN NO_DATA_FOUND THEN
				   w_exis := false;
			   END;
		   end if;

           -- Ahora compruebo las horas para acumularlo en la que corresponda
           CASE
		     when reg_sensoracct.acctstarttime >= '00:00'  and reg_sensoracct.acctstarttime < '01:00' then
			    w_sensortotal.tim00 := COALESCE(w_sensortotal.tim00,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num00 := 1;
		     when reg_sensoracct.acctstarttime >= '01:00' and reg_sensoracct.acctstarttime < '02:00' then
			    w_sensortotal.tim01 := COALESCE(w_sensortotal.tim01,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num01 := 1;
		     when reg_sensoracct.acctstarttime >= '02:00' and reg_sensoracct.acctstarttime < '03:00' then
			    w_sensortotal.tim02 := COALESCE(w_sensortotal.tim02,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num02 := 1;
		     when reg_sensoracct.acctstarttime >= '03:00' and reg_sensoracct.acctstarttime < '04:00' then
			    w_sensortotal.tim03 := COALESCE(w_sensortotal.tim03,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num03 := 1;
		     when reg_sensoracct.acctstarttime >= '04:00' and reg_sensoracct.acctstarttime < '05:00' then
			    w_sensortotal.tim04 := COALESCE(w_sensortotal.tim04,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num04 := 1;
		     when reg_sensoracct.acctstarttime >= '05:00' and reg_sensoracct.acctstarttime < '06:00' then
			    w_sensortotal.tim05 := COALESCE(w_sensortotal.tim05,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num05 := 1;
		     when reg_sensoracct.acctstarttime >= '06:00' and reg_sensoracct.acctstarttime < '07:00' then
			    w_sensortotal.tim06 := COALESCE(w_sensortotal.tim06,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num06 := 1;
		     when reg_sensoracct.acctstarttime >= '07:00' and reg_sensoracct.acctstarttime < '08:00' then
			    w_sensortotal.tim07 := COALESCE(w_sensortotal.tim07,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num07 := 1;
		     when reg_sensoracct.acctstarttime >= '08:00' and reg_sensoracct.acctstarttime < '09:00' then
			    w_sensortotal.tim08 := COALESCE(w_sensortotal.tim08,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num08 := 1;
		     when reg_sensoracct.acctstarttime >= '09:00' and reg_sensoracct.acctstarttime < '10:00' then
			    w_sensortotal.tim09 := COALESCE(w_sensortotal.tim09,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num09 := 1;
		     when reg_sensoracct.acctstarttime >= '10:00' and reg_sensoracct.acctstarttime < '11:00' then
			    w_sensortotal.tim10 := COALESCE(w_sensortotal.tim10,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num10 := 1;
		     when reg_sensoracct.acctstarttime >= '11:00' and reg_sensoracct.acctstarttime < '12:00' then
			    w_sensortotal.tim11 := COALESCE(w_sensortotal.tim11,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num11 := 1;
		     when reg_sensoracct.acctstarttime >= '12:00' and reg_sensoracct.acctstarttime < '13:00' then
			    w_sensortotal.tim12 := COALESCE(w_sensortotal.tim12,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num12 := 1;
		     when reg_sensoracct.acctstarttime >= '13:00' and reg_sensoracct.acctstarttime < '14:00' then
			    w_sensortotal.tim13 := COALESCE(w_sensortotal.tim13,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num13 := 1;
		     when reg_sensoracct.acctstarttime >= '14:00' and reg_sensoracct.acctstarttime < '15:00' then
			    w_sensortotal.tim14 := COALESCE(w_sensortotal.tim14,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num14 := 1;
		     when reg_sensoracct.acctstarttime >= '15:00' and reg_sensoracct.acctstarttime < '16:00' then
			    w_sensortotal.tim15 := COALESCE(w_sensortotal.tim15,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num15 := 1;
		     when reg_sensoracct.acctstarttime >= '16:00' and reg_sensoracct.acctstarttime < '17:00' then
			    w_sensortotal.tim16 := COALESCE(w_sensortotal.tim16,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num16 := 1;
		     when reg_sensoracct.acctstarttime >= '17:00' and reg_sensoracct.acctstarttime < '18:00' then
			    w_sensortotal.tim17 := COALESCE(w_sensortotal.tim17,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num17 := 1;
		     when reg_sensoracct.acctstarttime >= '18:00' and reg_sensoracct.acctstarttime < '19:00' then
			    w_sensortotal.tim18 := COALESCE(w_sensortotal.tim18,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num18 := 1;
		     when reg_sensoracct.acctstarttime >= '19:00' and reg_sensoracct.acctstarttime < '20:00' then
			    w_sensortotal.tim19 := COALESCE(w_sensortotal.tim19,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num19 := 1;
		     when reg_sensoracct.acctstarttime >= '20:00' and reg_sensoracct.acctstarttime < '21:00' then
			    w_sensortotal.tim20 := COALESCE(w_sensortotal.tim20,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num20 := 1;
		     when reg_sensoracct.acctstarttime >= '21:00' and reg_sensoracct.acctstarttime < '22:00' then
			    w_sensortotal.tim21 := COALESCE(w_sensortotal.tim21,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num21 := 1;
		     when reg_sensoracct.acctstarttime >= '22:00' and reg_sensoracct.acctstarttime < '23:00' then
			    w_sensortotal.tim22 := COALESCE(w_sensortotal.tim22,0)+reg_sensoracct.acctsessiontime;
				w_sensortotal.num22 := 1;
		     else
			    w_sensortotal.tim23 := COALESCE(w_sensortotal.tim23,0)+reg_sensoracct.acctsessiontime;
 				w_sensortotal.num23 := 1;
          END CASE;

		   -- Compruebo si se ha pasado de hora, en cuyo caso el tiempo son 3600'' y la diferencia se suma a la siguiente hora
		   if COALESCE(w_sensortotal.tim00,0) > 3600 then
			  w_sensortotal.tim01 := COALESCE(w_sensortotal.tim01,0)+ (w_sensortotal.tim00 - 3600);
			  w_sensortotal.tim00 := 3600;
			  w_sensortotal.num01 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim01,0) > 3600 then
			  w_sensortotal.tim02 := COALESCE(w_sensortotal.tim02,0)+ (w_sensortotal.tim01 - 3600);
			  w_sensortotal.tim01 := 3600;
			  w_sensortotal.num02 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim02,0) > 3600 then
			  w_sensortotal.tim03 := COALESCE(w_sensortotal.tim03,0)+ (w_sensortotal.tim02 - 3600);
			  w_sensortotal.tim02 := 3600;
			  w_sensortotal.num03 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim03,0) > 3600 then
			  w_sensortotal.tim04 := COALESCE(w_sensortotal.tim04,0)+ (w_sensortotal.tim03 - 3600);
			  w_sensortotal.tim03 := 3600;
			  w_sensortotal.num04 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim04,0) > 3600 then
			  w_sensortotal.tim05 := COALESCE(w_sensortotal.tim05,0)+ (w_sensortotal.tim04 - 3600);
			  w_sensortotal.tim04 := 3600;
 			  w_sensortotal.num05 := 1;
		   end if;
		   if COALESCE(w_sensortotal.tim05,0) > 3600 then
			  w_sensortotal.tim06 := COALESCE(w_sensortotal.tim06,0)+ (w_sensortotal.tim05 - 3600);
			  w_sensortotal.tim05 := 3600;
			  w_sensortotal.num06 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim06,0) > 3600 then
			  w_sensortotal.tim07 := COALESCE(w_sensortotal.tim07,0)+ (w_sensortotal.tim06 - 3600);
			  w_sensortotal.tim06 := 3600;
 			  w_sensortotal.num07 := 1;
		   end if;
		   if COALESCE(w_sensortotal.tim07,0) > 3600 then
			  w_sensortotal.tim08 := COALESCE(w_sensortotal.tim08,0)+ (w_sensortotal.tim07 - 3600);
			  w_sensortotal.tim07 := 3600;
			  w_sensortotal.num08 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim08,0) > 3600 then
			  w_sensortotal.tim09 := COALESCE(w_sensortotal.tim09,0)+ (w_sensortotal.tim08 - 3600);
			  w_sensortotal.tim08 := 3600;
			  w_sensortotal.num09 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim09,0) > 3600 then
			  w_sensortotal.tim10 := COALESCE(w_sensortotal.tim10,0)+ (w_sensortotal.tim09 - 3600);
			  w_sensortotal.tim09 := 3600;
			  w_sensortotal.num10 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim10,0) > 3600 then
			  w_sensortotal.tim11 := COALESCE(w_sensortotal.tim11,0)+ (w_sensortotal.tim10 - 3600);
			  w_sensortotal.tim10 := 3600;
			  w_sensortotal.num11 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim11,0) > 3600 then
			  w_sensortotal.tim12 := COALESCE(w_sensortotal.tim12,0)+ (w_sensortotal.tim11 - 3600);
			  w_sensortotal.tim11 := 3600;
			  w_sensortotal.num12 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim12,0) > 3600 then
			  w_sensortotal.tim13 := COALESCE(w_sensortotal.tim13,0)+ (w_sensortotal.tim12 - 3600);
			  w_sensortotal.tim12 := 3600;
			  w_sensortotal.num13 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim13,0) > 3600 then
			  w_sensortotal.tim14 := COALESCE(w_sensortotal.tim14,0)+ (w_sensortotal.tim13 - 3600);
			  w_sensortotal.tim13 := 3600;
			  w_sensortotal.num14 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim14,0) > 3600 then
			  w_sensortotal.tim15 := COALESCE(w_sensortotal.tim15,0)+ (w_sensortotal.tim14 - 3600);
			  w_sensortotal.tim14 := 3600;
			  w_sensortotal.num15 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim15,0) > 3600 then
			  w_sensortotal.tim16 := COALESCE(w_sensortotal.tim16,0)+ (w_sensortotal.tim15 - 3600);
			  w_sensortotal.tim15 := 3600;
			  w_sensortotal.num16 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim16,0) > 3600 then
			  w_sensortotal.tim17 := COALESCE(w_sensortotal.tim17,0)+ (w_sensortotal.tim16 - 3600);
			  w_sensortotal.tim16 := 3600;
			  w_sensortotal.num17 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim17,0) > 3600 then
			  w_sensortotal.tim18 := COALESCE(w_sensortotal.tim18,0)+ (w_sensortotal.tim17 - 3600);
			  w_sensortotal.tim17 := 3600;
 			  w_sensortotal.num18 := 1;
		   end if;
		   if COALESCE(w_sensortotal.tim18,0) > 3600 then
			  w_sensortotal.tim19 := COALESCE(w_sensortotal.tim19,0)+ (w_sensortotal.tim18 - 3600);
			  w_sensortotal.tim18 := 3600;
			  w_sensortotal.num19 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim19,0) > 3600 then
			  w_sensortotal.tim20 := COALESCE(w_sensortotal.tim20,0)+ (w_sensortotal.tim19 - 3600);
			  w_sensortotal.tim19 := 3600;
			  w_sensortotal.num20 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim20,0) > 3600 then
			  w_sensortotal.tim21 := COALESCE(w_sensortotal.tim21,0)+ (w_sensortotal.tim20 - 3600);
			  w_sensortotal.tim20 := 3600;
			  w_sensortotal.num21 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim21,0) > 3600 then
			  w_sensortotal.tim22 := COALESCE(w_sensortotal.tim22,0)+ (w_sensortotal.tim21 - 3600);
			  w_sensortotal.tim21 := 3600;
			  w_sensortotal.num22 := 1;
 		   end if;
		   if COALESCE(w_sensortotal.tim22,0) > 3600 then
			  w_sensortotal.tim23 := COALESCE(w_sensortotal.tim23,0)+ (w_sensortotal.tim22 - 3600);
			  w_sensortotal.tim22 := 3600;
			  w_sensortotal.num23 := 1;
 		   end if;

	         w_pendiente := true;
      	  end if;

		END IF;


      -- Por cada registro leido, modifico el valor de managed.
		UPDATE "smartpoke".rw_sensoracct
			SET managed='S'
			WHERE sensoracctid = reg_sensoracct.sensoracctid;
			w_registros := w_registros +1;
		FETCH cursor_sensoracct into reg_sensoracct;

    END LOOP; -- Fin bucle de dispositivos
		-- Compruebo si hay línea de totales pendiente de actualizar
	   if w_pendiente
	   then
		      w_totalizar := true;
  		      w_pendiente := false;
			  w_primero := true;
			  -- Debo actualizar la tabla de totales
			     select "smartpoke".actualizar_sensortotal
				    (w_sensortotal.spot_id, w_sensortotal.acctdate, w_sensortotal.pos, w_sensortotal.sensorname,
					w_sensortotal.devicemac, w_sensortotal.devicehashmac, w_sensortotal.brand,
					w_sensortotal.tim00, w_sensortotal.num00, w_sensortotal.tim01, w_sensortotal.num01, w_sensortotal.tim02, w_sensortotal.num02,
					w_sensortotal.tim03, w_sensortotal.num03, w_sensortotal.tim04, w_sensortotal.num04, w_sensortotal.tim05, w_sensortotal.num05,
					w_sensortotal.tim06, w_sensortotal.num06, w_sensortotal.tim07, w_sensortotal.num07, w_sensortotal.tim08, w_sensortotal.num08,
					w_sensortotal.tim09, w_sensortotal.num09, w_sensortotal.tim10, w_sensortotal.num10, w_sensortotal.tim11, w_sensortotal.num11,
					w_sensortotal.tim12, w_sensortotal.num12, w_sensortotal.tim13, w_sensortotal.num13, w_sensortotal.tim14, w_sensortotal.num14,
					w_sensortotal.tim15, w_sensortotal.num15, w_sensortotal.tim16, w_sensortotal.num16, w_sensortotal.tim17, w_sensortotal.num17,
					w_sensortotal.tim18, w_sensortotal.num18, w_sensortotal.tim19, w_sensortotal.num19, w_sensortotal.tim20, w_sensortotal.num20,
					w_sensortotal.tim21, w_sensortotal.num21, w_sensortotal.tim22, w_sensortotal.num22, w_sensortotal.tim23, w_sensortotal.num23,
					w_exis)
				   into w_retorno;
				 -- Si tiene usuario asociado actualizo los totales de smartpoketotal
				 if w_cont_user > 0 then
					select "smartpoke".actualizar_smartpoketotal
						(w_sensortotal.spot_id, w_sensortotal.acctdate, w_sensortotal.pos, w_sensortotal.sensorname,
						w_callingstationid, w_sensortotal.brand,
						w_sensortotal.tim00, w_sensortotal.num00, w_sensortotal.tim01, w_sensortotal.num01, w_sensortotal.tim02, w_sensortotal.num02,
						w_sensortotal.tim03, w_sensortotal.num03, w_sensortotal.tim04, w_sensortotal.num04, w_sensortotal.tim05, w_sensortotal.num05,
						w_sensortotal.tim06, w_sensortotal.num06, w_sensortotal.tim07, w_sensortotal.num07, w_sensortotal.tim08, w_sensortotal.num08,
						w_sensortotal.tim09, w_sensortotal.num09, w_sensortotal.tim10, w_sensortotal.num10, w_sensortotal.tim11, w_sensortotal.num11,
						w_sensortotal.tim12, w_sensortotal.num12, w_sensortotal.tim13, w_sensortotal.num13, w_sensortotal.tim14, w_sensortotal.num14,
						w_sensortotal.tim15, w_sensortotal.num15, w_sensortotal.tim16, w_sensortotal.num16, w_sensortotal.tim17, w_sensortotal.num17,
						w_sensortotal.tim18, w_sensortotal.num18, w_sensortotal.tim19, w_sensortotal.num19, w_sensortotal.tim20, w_sensortotal.num20,
						w_sensortotal.tim21, w_sensortotal.num21, w_sensortotal.tim22, w_sensortotal.num22, w_sensortotal.tim23, w_sensortotal.num23)
					  into w_retorno;
				 end if;

				   -- Una vez creado el registro debo inicializar los totales
				    w_sensortotal.tim00 := 0;
				    w_sensortotal.num00 := 0;
				    w_sensortotal.tim01 := 0;
				    w_sensortotal.num01 := 0;
				    w_sensortotal.tim02 := 0;
				    w_sensortotal.num02 := 0;
					w_sensortotal.tim03 := 0;
				    w_sensortotal.num03 := 0;
				    w_sensortotal.tim04 := 0;
				    w_sensortotal.num04 := 0;
				    w_sensortotal.tim05 := 0;
				    w_sensortotal.num05 := 0;
					w_sensortotal.tim06 := 0;
				    w_sensortotal.num06 := 0;
				    w_sensortotal.tim07 := 0;
				    w_sensortotal.num07 := 0;
				    w_sensortotal.tim08 := 0;
				    w_sensortotal.num08 := 0;
					w_sensortotal.tim09 := 0;
				    w_sensortotal.num09 := 0;
				    w_sensortotal.tim10 := 0;
				    w_sensortotal.num10 := 0;
				    w_sensortotal.tim11 := 0;
				    w_sensortotal.num11 := 0;
					w_sensortotal.tim12 := 0;
				    w_sensortotal.num12 := 0;
				    w_sensortotal.tim13 := 0;
				    w_sensortotal.num13 := 0;
				    w_sensortotal.tim14 := 0;
				    w_sensortotal.num14 := 0;
					w_sensortotal.tim15 := 0;
				    w_sensortotal.num15 := 0;
				    w_sensortotal.tim16 := 0;
				    w_sensortotal.num16 := 0;
				    w_sensortotal.tim17 := 0;
				    w_sensortotal.num17 := 0;
					w_sensortotal.tim18 := 0;
				    w_sensortotal.num18 := 0;
				    w_sensortotal.tim19 := 0;
				    w_sensortotal.num19 := 0;
				    w_sensortotal.tim20 := 0;
				    w_sensortotal.num20 := 0;
					w_sensortotal.tim21 := 0;
				    w_sensortotal.num21 := 0;
				    w_sensortotal.tim22 := 0;
				    w_sensortotal.num22 := 0;
				    w_sensortotal.tim23 := 0;
				    w_sensortotal.num23 := 0;

   		     w_totales := w_totales+1;
	   end if;

	   -- Debo actualizar la línea de totales para ese díspositivo si es necesario
	   if w_totalizar
	   then
				   select "smartpoke".actualizar_linea_total_sensortotal
						(w_sensortotal.spot_id, w_sensortotal.acctdate, w_sensortotal.sensorname,
						 w_sensortotal.devicemac, w_sensortotal.devicehashmac, w_sensortotal.brand
						 )
					into w_result;
					if w_result <> 'OK'
					then
					   RAISE EXCEPTION 'Error en la linea de Totales %', w_result;
					end if;

				 if w_cont_user > 0 then
				   select "smartpoke".actualizar_linea_total_smartpoketotal
						(w_sensortotal.spot_id, w_sensortotal.acctdate, w_sensortotal.sensorname,
						 w_callingstationid, w_sensortotal.brand
						 )
					into w_result;
					if w_result <> 'OK'
					then
					   RAISE EXCEPTION 'Error en la linea de Totales de smartpoketotal %', w_result;
					end if;
				 end if;

		  w_totalizar := false;
	   end if;

	   w_sensoracct := reg_sensoracct;
	 END LOOP; -- Fin bucle sensores

	END LOOP; -- Fin bucle spots

  END LOOP; -- Fin bucle registros sensoracct

  close cursor_sensoracct;
  p_result := 'Registros tratados '||w_registros||' Spots: '||w_spot||' Sensores '||w_sensores||' Disposi: '||w_dispositivos||' Totales:'||w_totales;

EXCEPTION
  WHEN NO_DATA_FOUND THEN
      p_result := 'Error '||SQLSTATE||' falta la información del Spot';
  WHEN OTHERS THEN
	p_result := 'Error '||SQLSTATE||' '||w_result;

END;

$$;


ALTER FUNCTION smartpoke.totalizar(OUT p_result character varying) OWNER TO esmartitpg;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 223 (class 1259 OID 17470)
-- Name: nas; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.nas (
    id integer NOT NULL,
    spot_id character varying(12) NOT NULL,
    nasname text NOT NULL,
    shortname text NOT NULL,
    type text DEFAULT 'other'::text NOT NULL,
    ports integer,
    secret text NOT NULL,
    server text,
    community text,
    description text
);


ALTER TABLE smartpoke.nas OWNER TO esmartitpg;

--
-- TOC entry 224 (class 1259 OID 17477)
-- Name: nas_id_seq; Type: SEQUENCE; Schema: smartpoke; Owner: esmartitpg
--

CREATE SEQUENCE smartpoke.nas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE smartpoke.nas_id_seq OWNER TO esmartitpg;

--
-- TOC entry 3328 (class 0 OID 0)
-- Dependencies: 224
-- Name: nas_id_seq; Type: SEQUENCE OWNED BY; Schema: smartpoke; Owner: esmartitpg
--

ALTER SEQUENCE smartpoke.nas_id_seq OWNED BY smartpoke.nas.id;


--
-- TOC entry 225 (class 1259 OID 17479)
-- Name: radacct; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.radacct (
    radacctid bigint NOT NULL,
    acctsessionid text NOT NULL,
    acctuniqueid text NOT NULL,
    username text,
    realm text,
    nasipaddress inet NOT NULL,
    nasportid text,
    nasporttype text,
    acctstarttime timestamp without time zone,
    acctupdatetime timestamp without time zone,
    acctstoptime timestamp without time zone,
    acctinterval bigint,
    acctsessiontime bigint,
    acctauthentic text,
    connectinfo_start text,
    connectinfo_stop text,
    acctinputoctets bigint,
    acctoutputoctets bigint,
    calledstationid text,
    callingstationid text,
    acctterminatecause text,
    servicetype text,
    framedprotocol text,
    framedipaddress inet,
    framedipv6address inet,
    framedipv6prefix inet,
    framedinterfaceid text,
    delegatedipv6prefix inet
);


ALTER TABLE smartpoke.radacct OWNER TO esmartitpg;

--
-- TOC entry 226 (class 1259 OID 17485)
-- Name: radacct_radacctid_seq; Type: SEQUENCE; Schema: smartpoke; Owner: esmartitpg
--

CREATE SEQUENCE smartpoke.radacct_radacctid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE smartpoke.radacct_radacctid_seq OWNER TO esmartitpg;

--
-- TOC entry 3329 (class 0 OID 0)
-- Dependencies: 226
-- Name: radacct_radacctid_seq; Type: SEQUENCE OWNED BY; Schema: smartpoke; Owner: esmartitpg
--

ALTER SEQUENCE smartpoke.radacct_radacctid_seq OWNED BY smartpoke.radacct.radacctid;


--
-- TOC entry 227 (class 1259 OID 17487)
-- Name: radcheck; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.radcheck (
    id integer NOT NULL,
    username text DEFAULT ''::text NOT NULL,
    attribute text DEFAULT ''::text NOT NULL,
    op character varying(2) DEFAULT '=='::character varying NOT NULL,
    value text DEFAULT ''::text NOT NULL
);


ALTER TABLE smartpoke.radcheck OWNER TO esmartitpg;

--
-- TOC entry 228 (class 1259 OID 17497)
-- Name: radcheck_id_seq; Type: SEQUENCE; Schema: smartpoke; Owner: esmartitpg
--

CREATE SEQUENCE smartpoke.radcheck_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE smartpoke.radcheck_id_seq OWNER TO esmartitpg;

--
-- TOC entry 3330 (class 0 OID 0)
-- Dependencies: 228
-- Name: radcheck_id_seq; Type: SEQUENCE OWNED BY; Schema: smartpoke; Owner: esmartitpg
--

ALTER SEQUENCE smartpoke.radcheck_id_seq OWNED BY smartpoke.radcheck.id;


--
-- TOC entry 229 (class 1259 OID 17499)
-- Name: radgroupcheck; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.radgroupcheck (
    id integer NOT NULL,
    spot_id character varying(12) NOT NULL,
    groupname text DEFAULT ''::text NOT NULL,
    attribute text DEFAULT ''::text NOT NULL,
    op character varying(2) DEFAULT '=='::character varying NOT NULL,
    value text DEFAULT ''::text NOT NULL
);


ALTER TABLE smartpoke.radgroupcheck OWNER TO esmartitpg;

--
-- TOC entry 230 (class 1259 OID 17509)
-- Name: radgroupcheck_id_seq; Type: SEQUENCE; Schema: smartpoke; Owner: esmartitpg
--

CREATE SEQUENCE smartpoke.radgroupcheck_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE smartpoke.radgroupcheck_id_seq OWNER TO esmartitpg;

--
-- TOC entry 3331 (class 0 OID 0)
-- Dependencies: 230
-- Name: radgroupcheck_id_seq; Type: SEQUENCE OWNED BY; Schema: smartpoke; Owner: esmartitpg
--

ALTER SEQUENCE smartpoke.radgroupcheck_id_seq OWNED BY smartpoke.radgroupcheck.id;


--
-- TOC entry 231 (class 1259 OID 17511)
-- Name: radgroupreply; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.radgroupreply (
    id integer NOT NULL,
    spot_id character varying(12) NOT NULL,
    groupname text DEFAULT ''::text NOT NULL,
    attribute text DEFAULT ''::text NOT NULL,
    op character varying(2) DEFAULT '='::character varying NOT NULL,
    value text DEFAULT ''::text NOT NULL
);


ALTER TABLE smartpoke.radgroupreply OWNER TO esmartitpg;

--
-- TOC entry 232 (class 1259 OID 17521)
-- Name: radgroupreply_id_seq; Type: SEQUENCE; Schema: smartpoke; Owner: esmartitpg
--

CREATE SEQUENCE smartpoke.radgroupreply_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE smartpoke.radgroupreply_id_seq OWNER TO esmartitpg;

--
-- TOC entry 3332 (class 0 OID 0)
-- Dependencies: 232
-- Name: radgroupreply_id_seq; Type: SEQUENCE OWNED BY; Schema: smartpoke; Owner: esmartitpg
--

ALTER SEQUENCE smartpoke.radgroupreply_id_seq OWNED BY smartpoke.radgroupreply.id;


--
-- TOC entry 233 (class 1259 OID 17523)
-- Name: radpostauth; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.radpostauth (
    id bigint NOT NULL,
    username text NOT NULL,
    pass text,
    reply text,
    calledstationid text,
    callingstationid text,
    authdate timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE smartpoke.radpostauth OWNER TO esmartitpg;

--
-- TOC entry 234 (class 1259 OID 17530)
-- Name: radpostauth_id_seq; Type: SEQUENCE; Schema: smartpoke; Owner: esmartitpg
--

CREATE SEQUENCE smartpoke.radpostauth_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE smartpoke.radpostauth_id_seq OWNER TO esmartitpg;

--
-- TOC entry 3333 (class 0 OID 0)
-- Dependencies: 234
-- Name: radpostauth_id_seq; Type: SEQUENCE OWNED BY; Schema: smartpoke; Owner: esmartitpg
--

ALTER SEQUENCE smartpoke.radpostauth_id_seq OWNED BY smartpoke.radpostauth.id;


--
-- TOC entry 235 (class 1259 OID 17532)
-- Name: radreply; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.radreply (
    id integer NOT NULL,
    username text DEFAULT ''::text NOT NULL,
    attribute text DEFAULT ''::text NOT NULL,
    op character varying(2) DEFAULT '='::character varying NOT NULL,
    value text DEFAULT ''::text NOT NULL
);


ALTER TABLE smartpoke.radreply OWNER TO esmartitpg;

--
-- TOC entry 236 (class 1259 OID 17542)
-- Name: radreply_id_seq; Type: SEQUENCE; Schema: smartpoke; Owner: esmartitpg
--

CREATE SEQUENCE smartpoke.radreply_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE smartpoke.radreply_id_seq OWNER TO esmartitpg;

--
-- TOC entry 3334 (class 0 OID 0)
-- Dependencies: 236
-- Name: radreply_id_seq; Type: SEQUENCE OWNED BY; Schema: smartpoke; Owner: esmartitpg
--

ALTER SEQUENCE smartpoke.radreply_id_seq OWNED BY smartpoke.radreply.id;


--
-- TOC entry 237 (class 1259 OID 17544)
-- Name: radusergroup; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.radusergroup (
    id integer NOT NULL,
    username text DEFAULT ''::text NOT NULL,
    groupname text DEFAULT ''::text NOT NULL,
    priority integer DEFAULT 0 NOT NULL
);


ALTER TABLE smartpoke.radusergroup OWNER TO esmartitpg;

--
-- TOC entry 238 (class 1259 OID 17553)
-- Name: radusergroup_id_seq; Type: SEQUENCE; Schema: smartpoke; Owner: esmartitpg
--

CREATE SEQUENCE smartpoke.radusergroup_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE smartpoke.radusergroup_id_seq OWNER TO esmartitpg;

--
-- TOC entry 3335 (class 0 OID 0)
-- Dependencies: 238
-- Name: radusergroup_id_seq; Type: SEQUENCE OWNED BY; Schema: smartpoke; Owner: esmartitpg
--

ALTER SEQUENCE smartpoke.radusergroup_id_seq OWNED BY smartpoke.radusergroup.id;


--
-- TOC entry 239 (class 1259 OID 17555)
-- Name: rs_hotspots; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.rs_hotspots (
    spot_id character varying(12) NOT NULL,
    name character varying(200) NOT NULL,
    mac character varying(200) NOT NULL,
    geocode character varying(200),
    creationdate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    creationby character varying(128),
    updatedate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updateby character varying(128)
);


ALTER TABLE smartpoke.rs_hotspots OWNER TO esmartitpg;

--
-- TOC entry 240 (class 1259 OID 17563)
-- Name: rs_spot_operators; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.rs_spot_operators (
    spot_id character varying(12) NOT NULL,
    operator_id bigint NOT NULL,
    access smallint NOT NULL,
    creationdate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    creationby character varying(128),
    updatedate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updateby character varying(128)
);


ALTER TABLE smartpoke.rs_spot_operators OWNER TO esmartitpg;

--
-- TOC entry 241 (class 1259 OID 17568)
-- Name: rs_userdevice; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.rs_userdevice (
    username character varying(128) NOT NULL,
    callingstationid character varying(50) NOT NULL,
    traffic bigint DEFAULT 0 NOT NULL
);


ALTER TABLE smartpoke.rs_userdevice OWNER TO esmartitpg;

--
-- TOC entry 242 (class 1259 OID 17572)
-- Name: rs_userinfo; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.rs_userinfo (
    spot_id character varying(12) NOT NULL,
    username character varying(128) NOT NULL,
    firstname character varying(200),
    lastname character varying(200),
    email character varying(200),
    mobilephone character varying(200) NOT NULL,
    birthdate date,
    gender character varying(1),
    zip character varying(200),
    flag_sms smallint DEFAULT '1'::smallint,
    creationdate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    creationby character varying(128),
    updatedate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updateby character varying(128)
);


ALTER TABLE smartpoke.rs_userinfo OWNER TO esmartitpg;

--
-- TOC entry 243 (class 1259 OID 17581)
-- Name: rw_devices; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.rw_devices (
    spot_id character varying(12) NOT NULL,
    devicemac character varying(200) NOT NULL,
    devicehashmac character varying(200),
    creationdate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    creationby character varying(128),
    updatedate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updateby character varying(128)
);


ALTER TABLE smartpoke.rw_devices OWNER TO esmartitpg;

--
-- TOC entry 244 (class 1259 OID 17589)
-- Name: rw_messages; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.rw_messages (
    id bigint NOT NULL,
    spot_id character varying(12) NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description character varying(200) DEFAULT ''::character varying NOT NULL,
    image bytea,
    validdate date NOT NULL,
    creationdate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    creationby character varying(128),
    updatedate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updateby character varying(128)
);


ALTER TABLE smartpoke.rw_messages OWNER TO esmartitpg;

--
-- TOC entry 245 (class 1259 OID 17599)
-- Name: rw_messages_detail; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.rw_messages_detail (
    id bigint NOT NULL,
    spot_id character varying(12) NOT NULL,
    message_id integer NOT NULL,
    devicehashmac character varying(200),
    username character varying(128),
    acctstartdate timestamp without time zone,
    status smallint NOT NULL,
    description character varying(200)
);


ALTER TABLE smartpoke.rw_messages_detail OWNER TO esmartitpg;

--
-- TOC entry 246 (class 1259 OID 17605)
-- Name: rw_messages_detail_id_seq; Type: SEQUENCE; Schema: smartpoke; Owner: esmartitpg
--

CREATE SEQUENCE smartpoke.rw_messages_detail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE smartpoke.rw_messages_detail_id_seq OWNER TO esmartitpg;

--
-- TOC entry 3336 (class 0 OID 0)
-- Dependencies: 246
-- Name: rw_messages_detail_id_seq; Type: SEQUENCE OWNED BY; Schema: smartpoke; Owner: esmartitpg
--

ALTER SEQUENCE smartpoke.rw_messages_detail_id_seq OWNED BY smartpoke.rw_messages_detail.id;


--
-- TOC entry 247 (class 1259 OID 17607)
-- Name: rw_messages_id_seq; Type: SEQUENCE; Schema: smartpoke; Owner: esmartitpg
--

CREATE SEQUENCE smartpoke.rw_messages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE smartpoke.rw_messages_id_seq OWNER TO esmartitpg;

--
-- TOC entry 3337 (class 0 OID 0)
-- Dependencies: 247
-- Name: rw_messages_id_seq; Type: SEQUENCE OWNED BY; Schema: smartpoke; Owner: esmartitpg
--

ALTER SEQUENCE smartpoke.rw_messages_id_seq OWNED BY smartpoke.rw_messages.id;


--
-- TOC entry 248 (class 1259 OID 17609)
-- Name: rw_sensor; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.rw_sensor (
    spot_id character varying(12) NOT NULL,
    sensorname character varying(12) NOT NULL,
    location character varying(50),
    pwr_in character varying(50) DEFAULT '-30'::character varying NOT NULL,
    pwr_limit character varying(50) DEFAULT '-40'::character varying NOT NULL,
    pwr_out character varying(50) DEFAULT '-50'::character varying NOT NULL,
    creationdate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    creationby character varying(128),
    updatedate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updateby character varying(128)
);


ALTER TABLE smartpoke.rw_sensor OWNER TO esmartitpg;

--
-- TOC entry 249 (class 1259 OID 17617)
-- Name: rw_sensoracct; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.rw_sensoracct (
    sensoracctid bigint NOT NULL,
    spot_id character varying(12) NOT NULL,
    sensorname character varying(12) NOT NULL,
    devicemac character varying(200),
    devicehashmac character varying(200),
    acctstartdate date,
    acctstarttime time without time zone,
    acctstopdate date,
    acctstoptime time without time zone,
    acctsessiontime bigint,
    acctpower bigint,
    acctpackage bigint,
    acctdistance numeric(10,2) DEFAULT 0.00 NOT NULL,
    managed character varying(1) DEFAULT 'N'::character varying NOT NULL
);


ALTER TABLE smartpoke.rw_sensoracct OWNER TO esmartitpg;

--
-- TOC entry 250 (class 1259 OID 17622)
-- Name: rw_sensoracct_sensoracctid_seq; Type: SEQUENCE; Schema: smartpoke; Owner: esmartitpg
--

CREATE SEQUENCE smartpoke.rw_sensoracct_sensoracctid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE smartpoke.rw_sensoracct_sensoracctid_seq OWNER TO esmartitpg;

--
-- TOC entry 3338 (class 0 OID 0)
-- Dependencies: 250
-- Name: rw_sensoracct_sensoracctid_seq; Type: SEQUENCE OWNED BY; Schema: smartpoke; Owner: esmartitpg
--

ALTER SEQUENCE smartpoke.rw_sensoracct_sensoracctid_seq OWNED BY smartpoke.rw_sensoracct.sensoracctid;


--
-- TOC entry 251 (class 1259 OID 17624)
-- Name: rw_sensortotal; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.rw_sensortotal (
    spot_id character varying(12) NOT NULL,
    acctdate date NOT NULL,
    pos character varying(5) NOT NULL,
    sensorname character varying(12) NOT NULL,
    devicemac character varying(200) NOT NULL,
    devicehashmac character varying(200) NOT NULL,
    brand character varying(50) DEFAULT 'NO BRAND'::character varying NOT NULL,
    tim00 bigint DEFAULT '0'::bigint NOT NULL,
    num00 bigint DEFAULT '0'::bigint NOT NULL,
    tim01 bigint DEFAULT '0'::bigint NOT NULL,
    num01 bigint DEFAULT '0'::bigint NOT NULL,
    tim02 bigint DEFAULT '0'::bigint NOT NULL,
    num02 bigint DEFAULT '0'::bigint NOT NULL,
    tim03 bigint DEFAULT '0'::bigint NOT NULL,
    num03 bigint DEFAULT '0'::bigint NOT NULL,
    tim04 bigint DEFAULT '0'::bigint NOT NULL,
    num04 bigint DEFAULT '0'::bigint NOT NULL,
    tim05 bigint DEFAULT '0'::bigint NOT NULL,
    num05 bigint DEFAULT '0'::bigint NOT NULL,
    tim06 bigint DEFAULT '0'::bigint NOT NULL,
    num06 bigint DEFAULT '0'::bigint NOT NULL,
    tim07 bigint DEFAULT '0'::bigint NOT NULL,
    num07 bigint DEFAULT '0'::bigint NOT NULL,
    tim08 bigint DEFAULT '0'::bigint NOT NULL,
    num08 bigint DEFAULT '0'::bigint NOT NULL,
    tim09 bigint DEFAULT '0'::bigint NOT NULL,
    num09 bigint DEFAULT '0'::bigint NOT NULL,
    tim10 bigint DEFAULT '0'::bigint NOT NULL,
    num10 bigint DEFAULT '0'::bigint NOT NULL,
    tim11 bigint DEFAULT '0'::bigint NOT NULL,
    num11 bigint DEFAULT '0'::bigint NOT NULL,
    tim12 bigint DEFAULT '0'::bigint NOT NULL,
    num12 bigint DEFAULT '0'::bigint NOT NULL,
    tim13 bigint DEFAULT '0'::bigint NOT NULL,
    num13 bigint DEFAULT '0'::bigint NOT NULL,
    tim14 bigint DEFAULT '0'::bigint NOT NULL,
    num14 bigint DEFAULT '0'::bigint NOT NULL,
    tim15 bigint DEFAULT '0'::bigint NOT NULL,
    num15 bigint DEFAULT '0'::bigint NOT NULL,
    tim16 bigint DEFAULT '0'::bigint NOT NULL,
    num16 bigint DEFAULT '0'::bigint NOT NULL,
    tim17 bigint DEFAULT '0'::bigint NOT NULL,
    num17 bigint DEFAULT '0'::bigint NOT NULL,
    tim18 bigint DEFAULT '0'::bigint NOT NULL,
    num18 bigint DEFAULT '0'::bigint NOT NULL,
    tim19 bigint DEFAULT '0'::bigint NOT NULL,
    num19 bigint DEFAULT '0'::bigint NOT NULL,
    tim20 bigint DEFAULT '0'::bigint NOT NULL,
    num20 bigint DEFAULT '0'::bigint NOT NULL,
    tim21 bigint DEFAULT '0'::bigint NOT NULL,
    num21 bigint DEFAULT '0'::bigint NOT NULL,
    tim22 bigint DEFAULT '0'::bigint NOT NULL,
    num22 bigint DEFAULT '0'::bigint NOT NULL,
    tim23 bigint DEFAULT '0'::bigint NOT NULL,
    num23 bigint DEFAULT '0'::bigint NOT NULL,
    timto bigint DEFAULT '0'::bigint NOT NULL,
    numto bigint DEFAULT '0'::bigint NOT NULL
);


ALTER TABLE smartpoke.rw_sensortotal OWNER TO esmartitpg;

--
-- TOC entry 252 (class 1259 OID 17681)
-- Name: rw_settings; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.rw_settings (
    spot_id character varying(12) NOT NULL,
    name character varying(64) DEFAULT ''::character varying NOT NULL,
    value character varying(253) DEFAULT ''::character varying NOT NULL,
    creationdate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    creationby character varying(128),
    updatedate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updateby character varying(128)
);


ALTER TABLE smartpoke.rw_settings OWNER TO esmartitpg;

--
-- TOC entry 253 (class 1259 OID 17691)
-- Name: rw_smartpoketotal; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.rw_smartpoketotal (
    spot_id character varying(12) NOT NULL,
    sensorname character varying(12) NOT NULL,
    callingstationid character varying(50) NOT NULL,
    acctdate date NOT NULL,
    pos character varying(5) NOT NULL,
    brand character varying(50) DEFAULT 'NO BRAND'::character varying NOT NULL,
    tim00 bigint DEFAULT '0'::bigint NOT NULL,
    num00 bigint DEFAULT '0'::bigint NOT NULL,
    tim01 bigint DEFAULT '0'::bigint NOT NULL,
    num01 bigint DEFAULT '0'::bigint NOT NULL,
    tim02 bigint DEFAULT '0'::bigint NOT NULL,
    num02 bigint DEFAULT '0'::bigint NOT NULL,
    tim03 bigint DEFAULT '0'::bigint NOT NULL,
    num03 bigint DEFAULT '0'::bigint NOT NULL,
    tim04 bigint DEFAULT '0'::bigint NOT NULL,
    num04 bigint DEFAULT '0'::bigint NOT NULL,
    tim05 bigint DEFAULT '0'::bigint NOT NULL,
    num05 bigint DEFAULT '0'::bigint NOT NULL,
    tim06 bigint DEFAULT '0'::bigint NOT NULL,
    num06 bigint DEFAULT '0'::bigint NOT NULL,
    tim07 bigint DEFAULT '0'::bigint NOT NULL,
    num07 bigint DEFAULT '0'::bigint NOT NULL,
    tim08 bigint DEFAULT '0'::bigint NOT NULL,
    num08 bigint DEFAULT '0'::bigint NOT NULL,
    tim09 bigint DEFAULT '0'::bigint NOT NULL,
    num09 bigint DEFAULT '0'::bigint NOT NULL,
    tim10 bigint DEFAULT '0'::bigint NOT NULL,
    num10 bigint DEFAULT '0'::bigint NOT NULL,
    tim11 bigint DEFAULT '0'::bigint NOT NULL,
    num11 bigint DEFAULT '0'::bigint NOT NULL,
    tim12 bigint DEFAULT '0'::bigint NOT NULL,
    num12 bigint DEFAULT '0'::bigint NOT NULL,
    tim13 bigint DEFAULT '0'::bigint NOT NULL,
    num13 bigint DEFAULT '0'::bigint NOT NULL,
    tim14 bigint DEFAULT '0'::bigint NOT NULL,
    num14 bigint DEFAULT '0'::bigint NOT NULL,
    tim15 bigint DEFAULT '0'::bigint NOT NULL,
    num15 bigint DEFAULT '0'::bigint NOT NULL,
    tim16 bigint DEFAULT '0'::bigint NOT NULL,
    num16 bigint DEFAULT '0'::bigint NOT NULL,
    tim17 bigint DEFAULT '0'::bigint NOT NULL,
    num17 bigint DEFAULT '0'::bigint NOT NULL,
    tim18 bigint DEFAULT '0'::bigint NOT NULL,
    num18 bigint DEFAULT '0'::bigint NOT NULL,
    tim19 bigint DEFAULT '0'::bigint NOT NULL,
    num19 bigint DEFAULT '0'::bigint NOT NULL,
    tim20 bigint DEFAULT '0'::bigint NOT NULL,
    num20 bigint DEFAULT '0'::bigint NOT NULL,
    tim21 bigint DEFAULT '0'::bigint NOT NULL,
    num21 bigint DEFAULT '0'::bigint NOT NULL,
    tim22 bigint DEFAULT '0'::bigint NOT NULL,
    num22 bigint DEFAULT '0'::bigint NOT NULL,
    tim23 bigint DEFAULT '0'::bigint NOT NULL,
    num23 bigint DEFAULT '0'::bigint NOT NULL,
    timto bigint DEFAULT '0'::bigint NOT NULL,
    numto bigint DEFAULT '0'::bigint NOT NULL
);


ALTER TABLE smartpoke.rw_smartpoketotal OWNER TO esmartitpg;

--
-- TOC entry 254 (class 1259 OID 17745)
-- Name: rw_spot; Type: TABLE; Schema: smartpoke; Owner: esmartitpg
--

CREATE TABLE smartpoke.rw_spot (
    spot_id character varying(12) NOT NULL,
    spot_name character varying(128) NOT NULL,
    timestart time without time zone DEFAULT '00:00:00'::time without time zone,
    timestop time without time zone DEFAULT '23:59:59'::time without time zone,
    country_id integer,
    state_id integer,
    city_id integer,
    location_id integer,
    zipcode character varying(10),
    business_id integer,
    creationdate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    creationby character varying(128),
    updatedate timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updateby character varying(128)
);


ALTER TABLE smartpoke.rw_spot OWNER TO esmartitpg;

--
-- TOC entry 255 (class 1259 OID 17752)
-- Name: sensor_acct_aggregate_view; Type: MATERIALIZED VIEW; Schema: smartpoke; Owner: esmartitpg
--

CREATE MATERIALIZED VIEW smartpoke.sensor_acct_aggregate_view AS
 SELECT DISTINCT act.spot_id,
    act.sensorname,
    act.acctstartdate,
    act.devicehashmac,
    p.brand,
    date_part('hour'::text, act.acctstarttime) AS accttime,
    max(
        CASE
            WHEN ((act.acctpower)::numeric >= (sn.pwr_in)::numeric) THEN 3
            WHEN ((act.acctpower)::numeric >= (sn.pwr_limit)::numeric) THEN 2
            ELSE 1
        END) OVER (PARTITION BY act.acctstartdate, (date_part('hour'::text, act.acctstarttime)), act.spot_id, act.sensorname, act.devicehashmac) AS pos_hour,
    sum(act.acctsessiontime) OVER (PARTITION BY act.acctstartdate, (date_part('hour'::text, act.acctstarttime)), act.spot_id, act.sensorname, act.devicehashmac) AS time_hour
   FROM ((smartpoke.rw_sensoracct act
     JOIN smartpoke.rw_sensor sn ON ((((act.spot_id)::text = (sn.spot_id)::text) AND ((act.sensorname)::text = (sn.sensorname)::text) AND ((act.acctpower)::numeric >= (sn.pwr_out)::numeric))))
     LEFT JOIN esmartit.rw_providers p ON (((act.devicemac)::text = (p.providermac)::text)))
  WHERE (act.acctpower < '-1'::integer)
  ORDER BY act.acctstartdate, act.devicehashmac, (date_part('hour'::text, act.acctstarttime))
  WITH NO DATA;


ALTER TABLE smartpoke.sensor_acct_aggregate_view OWNER TO esmartitpg;

--
-- TOC entry 2977 (class 2604 OID 17760)
-- Name: nas id; Type: DEFAULT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.nas ALTER COLUMN id SET DEFAULT nextval('smartpoke.nas_id_seq'::regclass);


--
-- TOC entry 2978 (class 2604 OID 17761)
-- Name: radacct radacctid; Type: DEFAULT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.radacct ALTER COLUMN radacctid SET DEFAULT nextval('smartpoke.radacct_radacctid_seq'::regclass);


--
-- TOC entry 2983 (class 2604 OID 17762)
-- Name: radcheck id; Type: DEFAULT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.radcheck ALTER COLUMN id SET DEFAULT nextval('smartpoke.radcheck_id_seq'::regclass);


--
-- TOC entry 2988 (class 2604 OID 17763)
-- Name: radgroupcheck id; Type: DEFAULT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.radgroupcheck ALTER COLUMN id SET DEFAULT nextval('smartpoke.radgroupcheck_id_seq'::regclass);


--
-- TOC entry 2993 (class 2604 OID 17764)
-- Name: radgroupreply id; Type: DEFAULT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.radgroupreply ALTER COLUMN id SET DEFAULT nextval('smartpoke.radgroupreply_id_seq'::regclass);


--
-- TOC entry 2995 (class 2604 OID 17765)
-- Name: radpostauth id; Type: DEFAULT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.radpostauth ALTER COLUMN id SET DEFAULT nextval('smartpoke.radpostauth_id_seq'::regclass);


--
-- TOC entry 3000 (class 2604 OID 17766)
-- Name: radreply id; Type: DEFAULT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.radreply ALTER COLUMN id SET DEFAULT nextval('smartpoke.radreply_id_seq'::regclass);


--
-- TOC entry 3004 (class 2604 OID 17767)
-- Name: radusergroup id; Type: DEFAULT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.radusergroup ALTER COLUMN id SET DEFAULT nextval('smartpoke.radusergroup_id_seq'::regclass);


--
-- TOC entry 3019 (class 2604 OID 17768)
-- Name: rw_messages id; Type: DEFAULT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rw_messages ALTER COLUMN id SET DEFAULT nextval('smartpoke.rw_messages_id_seq'::regclass);


--
-- TOC entry 3020 (class 2604 OID 17769)
-- Name: rw_messages_detail id; Type: DEFAULT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rw_messages_detail ALTER COLUMN id SET DEFAULT nextval('smartpoke.rw_messages_detail_id_seq'::regclass);


--
-- TOC entry 3028 (class 2604 OID 17770)
-- Name: rw_sensoracct sensoracctid; Type: DEFAULT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rw_sensoracct ALTER COLUMN sensoracctid SET DEFAULT nextval('smartpoke.rw_sensoracct_sensoracctid_seq'::regclass);


--
-- TOC entry 3141 (class 2606 OID 17772)
-- Name: nas nas_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.nas
    ADD CONSTRAINT nas_pkey PRIMARY KEY (id);


--
-- TOC entry 3143 (class 2606 OID 17774)
-- Name: radacct radacct_acctuniqueid_key; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.radacct
    ADD CONSTRAINT radacct_acctuniqueid_key UNIQUE (acctuniqueid);


--
-- TOC entry 3147 (class 2606 OID 17776)
-- Name: radacct radacct_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.radacct
    ADD CONSTRAINT radacct_pkey PRIMARY KEY (radacctid);


--
-- TOC entry 3150 (class 2606 OID 17778)
-- Name: radcheck radcheck_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.radcheck
    ADD CONSTRAINT radcheck_pkey PRIMARY KEY (id);


--
-- TOC entry 3154 (class 2606 OID 17780)
-- Name: radgroupcheck radgroupcheck_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.radgroupcheck
    ADD CONSTRAINT radgroupcheck_pkey PRIMARY KEY (id);


--
-- TOC entry 3157 (class 2606 OID 17782)
-- Name: radgroupreply radgroupreply_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.radgroupreply
    ADD CONSTRAINT radgroupreply_pkey PRIMARY KEY (id);


--
-- TOC entry 3159 (class 2606 OID 17784)
-- Name: radpostauth radpostauth_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.radpostauth
    ADD CONSTRAINT radpostauth_pkey PRIMARY KEY (id);


--
-- TOC entry 3161 (class 2606 OID 17786)
-- Name: radreply radreply_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.radreply
    ADD CONSTRAINT radreply_pkey PRIMARY KEY (id);


--
-- TOC entry 3164 (class 2606 OID 17788)
-- Name: radusergroup radusergroup_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.radusergroup
    ADD CONSTRAINT radusergroup_pkey PRIMARY KEY (id);


--
-- TOC entry 3168 (class 2606 OID 17790)
-- Name: rs_hotspots rs_hotspots_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rs_hotspots
    ADD CONSTRAINT rs_hotspots_pkey PRIMARY KEY (spot_id, name);


--
-- TOC entry 3170 (class 2606 OID 17792)
-- Name: rs_spot_operators rs_spot_operators_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rs_spot_operators
    ADD CONSTRAINT rs_spot_operators_pkey PRIMARY KEY (spot_id, operator_id);


--
-- TOC entry 3173 (class 2606 OID 17794)
-- Name: rs_userdevice rs_userdevice_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rs_userdevice
    ADD CONSTRAINT rs_userdevice_pkey PRIMARY KEY (username, callingstationid);


--
-- TOC entry 3175 (class 2606 OID 17796)
-- Name: rs_userinfo rs_userinfo_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rs_userinfo
    ADD CONSTRAINT rs_userinfo_pkey PRIMARY KEY (spot_id, username);


--
-- TOC entry 3177 (class 2606 OID 17798)
-- Name: rw_devices rw_devices_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rw_devices
    ADD CONSTRAINT rw_devices_pkey PRIMARY KEY (spot_id, devicemac);


--
-- TOC entry 3182 (class 2606 OID 17800)
-- Name: rw_messages_detail rw_messages_detail_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rw_messages_detail
    ADD CONSTRAINT rw_messages_detail_pkey PRIMARY KEY (id);


--
-- TOC entry 3180 (class 2606 OID 17802)
-- Name: rw_messages rw_messages_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rw_messages
    ADD CONSTRAINT rw_messages_pkey PRIMARY KEY (id);


--
-- TOC entry 3184 (class 2606 OID 17804)
-- Name: rw_sensor rw_sensor_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rw_sensor
    ADD CONSTRAINT rw_sensor_pkey PRIMARY KEY (spot_id, sensorname);


--
-- TOC entry 3187 (class 2606 OID 17806)
-- Name: rw_sensoracct rw_sensoracct_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rw_sensoracct
    ADD CONSTRAINT rw_sensoracct_pkey PRIMARY KEY (sensoracctid);


--
-- TOC entry 3190 (class 2606 OID 17808)
-- Name: rw_sensortotal rw_sensortotal_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rw_sensortotal
    ADD CONSTRAINT rw_sensortotal_pkey PRIMARY KEY (spot_id, acctdate, pos, sensorname, devicemac, devicehashmac);


--
-- TOC entry 3192 (class 2606 OID 17810)
-- Name: rw_settings rw_settings_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rw_settings
    ADD CONSTRAINT rw_settings_pkey PRIMARY KEY (spot_id, name);


--
-- TOC entry 3195 (class 2606 OID 17812)
-- Name: rw_smartpoketotal rw_smartpoketotal_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rw_smartpoketotal
    ADD CONSTRAINT rw_smartpoketotal_pkey PRIMARY KEY (spot_id, sensorname, callingstationid, acctdate, pos);


--
-- TOC entry 3197 (class 2606 OID 17814)
-- Name: rw_spot rw_spot_pkey; Type: CONSTRAINT; Schema: smartpoke; Owner: esmartitpg
--

ALTER TABLE ONLY smartpoke.rw_spot
    ADD CONSTRAINT rw_spot_pkey PRIMARY KEY (spot_id);


--
-- TOC entry 3139 (class 1259 OID 17815)
-- Name: nas_nasname; Type: INDEX; Schema: smartpoke; Owner: esmartitpg
--

CREATE INDEX nas_nasname ON smartpoke.nas USING btree (nasname);


--
-- TOC entry 3144 (class 1259 OID 17816)
-- Name: radacct_active_session_idx; Type: INDEX; Schema: smartpoke; Owner: esmartitpg
--

CREATE INDEX radacct_active_session_idx ON smartpoke.radacct USING btree (acctuniqueid) WHERE (acctstoptime IS NULL);


--
-- TOC entry 3145 (class 1259 OID 17817)
-- Name: radacct_bulk_close; Type: INDEX; Schema: smartpoke; Owner: esmartitpg
--

CREATE INDEX radacct_bulk_close ON smartpoke.radacct USING btree (nasipaddress, acctstarttime) WHERE (acctstoptime IS NULL);


--
-- TOC entry 3148 (class 1259 OID 17818)
-- Name: radacct_start_user_idx; Type: INDEX; Schema: smartpoke; Owner: esmartitpg
--

CREATE INDEX radacct_start_user_idx ON smartpoke.radacct USING btree (acctstarttime, username);


--
-- TOC entry 3151 (class 1259 OID 17819)
-- Name: radcheck_username; Type: INDEX; Schema: smartpoke; Owner: esmartitpg
--

CREATE INDEX radcheck_username ON smartpoke.radcheck USING btree (username, attribute);


--
-- TOC entry 3152 (class 1259 OID 17820)
-- Name: radgroupcheck_groupname; Type: INDEX; Schema: smartpoke; Owner: esmartitpg
--

CREATE INDEX radgroupcheck_groupname ON smartpoke.radgroupcheck USING btree (groupname, attribute);


--
-- TOC entry 3155 (class 1259 OID 17821)
-- Name: radgroupreply_groupname; Type: INDEX; Schema: smartpoke; Owner: esmartitpg
--

CREATE INDEX radgroupreply_groupname ON smartpoke.radgroupreply USING btree (groupname, attribute);


--
-- TOC entry 3162 (class 1259 OID 17822)
-- Name: radreply_username; Type: INDEX; Schema: smartpoke; Owner: esmartitpg
--

CREATE INDEX radreply_username ON smartpoke.radreply USING btree (username, attribute);


--
-- TOC entry 3165 (class 1259 OID 17823)
-- Name: radusergroup_username; Type: INDEX; Schema: smartpoke; Owner: esmartitpg
--

CREATE INDEX radusergroup_username ON smartpoke.radusergroup USING btree (username);


--
-- TOC entry 3166 (class 1259 OID 17824)
-- Name: rs_hotspots_ix; Type: INDEX; Schema: smartpoke; Owner: esmartitpg
--

CREATE INDEX rs_hotspots_ix ON smartpoke.rs_hotspots USING btree (mac);


--
-- TOC entry 3171 (class 1259 OID 17825)
-- Name: rs_userdevice_ix; Type: INDEX; Schema: smartpoke; Owner: esmartitpg
--

CREATE INDEX rs_userdevice_ix ON smartpoke.rs_userdevice USING btree (callingstationid DESC NULLS LAST);


--
-- TOC entry 3178 (class 1259 OID 17826)
-- Name: rw_messages_ix; Type: INDEX; Schema: smartpoke; Owner: esmartitpg
--

CREATE INDEX rw_messages_ix ON smartpoke.rw_messages USING btree (validdate);


--
-- TOC entry 3185 (class 1259 OID 17827)
-- Name: rw_sensoracct_ix; Type: INDEX; Schema: smartpoke; Owner: esmartitpg
--

CREATE INDEX rw_sensoracct_ix ON smartpoke.rw_sensoracct USING btree (managed NULLS FIRST);


--
-- TOC entry 3188 (class 1259 OID 17828)
-- Name: rw_sensortotal_ix; Type: INDEX; Schema: smartpoke; Owner: esmartitpg
--

CREATE INDEX rw_sensortotal_ix ON smartpoke.rw_sensortotal USING btree (acctdate DESC, pos, spot_id, brand);


--
-- TOC entry 3193 (class 1259 OID 17829)
-- Name: rw_smartpoketotal_ix; Type: INDEX; Schema: smartpoke; Owner: esmartitpg
--

CREATE INDEX rw_smartpoketotal_ix ON smartpoke.rw_smartpoketotal USING btree (acctdate DESC NULLS LAST, pos);
