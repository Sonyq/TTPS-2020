<template>
    <div>
        <form>
            <md-card>
            <md-card-header data-background-color="green">
                <h3 class="title">Nueva evolución</h3>
            </md-card-header>

            <md-card-content>

                <div class="md-layout">

                    <div class="md-layout-item md-small-size-100 md-size-50">

                        <h4>Signos vitales</h4>

                            <div class="md-layout-item md-small-size-40 md-size-40">
                                <md-field>
                                    <label>Temperatura</label>
                                    <md-input v-model="temperatura" type="number"></md-input>
                                </md-field>
                            </div>

                            <div class="md-layout">

                                <div class="md-layout-item md-small-size-40 md-size-40">
                                    <md-field>
                                        <label>TA Sistólica</label>
                                        <md-input v-model="taSistolica" type="number"></md-input>
                                    </md-field>
                                </div>

                                <div class="md-layout-item md-small-size-40 md-size-40">
                                    <md-field>
                                        <label>TA diastólica</label>
                                        <md-input v-model="taDiastolica" type="number"></md-input>
                                    </md-field>
                                </div>

                            </div>

                            <div class="md-layout">

                                <div class="md-layout-item md-small-size-40 md-size-40">
                                    <md-field>
                                        <label>Frecuencia cardíaca</label>
                                        <md-input v-model="frecuenciaCardiaca" type="number"></md-input>
                                    </md-field>
                                </div>
                    
                                <div class="md-layout-item md-small-size-40 md-size-40">
                                    <md-field>
                                        <label>Frecuencia respiratoria</label>
                                        <md-input v-model="frecuenciaRespiratoria" type="number"></md-input>
                                    </md-field>
                                </div>
                             
                             </div>
                        
                        <br>

                        <h4>Sistema respiratorio</h4>

                            <div class="md-layout-item md-small-size-40 md-size-40" >
                                <md-field>
                                    <label for="mecanicaVentilatoria">Mecánica ventilatoria</label>
                                    <md-select v-model="mecanicaVentilatoria" name="mecanicaVentilatoria">              
                                        <md-option value="buena">Buena</md-option>
                                        <md-option value="regular">Regular</md-option>
                                        <md-option value="mala">Mala</md-option>                                        
                                    </md-select>
                                </md-field>
                            </div>

                            <div class="md-layout-item md-small-size-40 md-size-40" >
                                <md-switch class="md-primary" v-model="requiereO2">Requiere O2 suplementario</md-switch>
                            </div>

                                <!-- esto se muestra si requiereO2 es true -->
                                <div class="md-layout-item md-small-size-100 md-size-100" v-show="requiereO2">

                                    <div class="md-layout">
                                        <div class="md-layout-item md-small-size-50 md-size-50" >
                                            <md-field>
                                                <label for="tipoAdministracionO2">Tipo Administración O2</label>
                                                <md-select v-model="tipoAdministracionO2" name="tipoAdministracionO2">
                                                    <md-option :value="false">Ninguna</md-option>             
                                                    <md-option value="Cánula nasal">Cánula nasal de oxígeno</md-option>
                                                    <md-option value="Máscara con reservorio">Máscara con reservorio</md-option>
                                                </md-select>
                                            </md-field>
                                        </div>

                                        <!-- esto se muestra si se setea tipo de administración O2 es true -->
                                        <div class="md-layout-item md-small-size-50 md-size-50" >
                                            <md-field v-if="tipoAdministracionO2 == 'Cánula nasal'">
                                                <label>Valor cánula nasal</label>
                                                <md-input v-model="canulaNasalValor" type="number"></md-input>
                                            </md-field>

                                            <md-field v-if="tipoAdministracionO2 == 'Máscara con reservorio'">
                                                <label>Valor máscara con reservorio</label>
                                                <md-input v-model="mascaraReservorioValor" type="number"></md-input>
                                            </md-field>
                                        </div>


                                        <!-- hasta acá si se setea tipo de administración O2 -->
                                    </div>  


                                    <div class="md-layout-item md-small-size-40 md-size-40">
                                        <md-field>
                                            <label>Saturación O2</label>
                                            <md-input v-model="satO2" type="number"></md-input>
                                        </md-field>
                                    </div>

                                    <div class="md-layout-item md-small-size-40 md-size-40" >
                                        <md-switch class="md-primary" v-model="pafi">PaO2/FiO2</md-switch>
                                        <!-- esto se muestra si pafi es true -->
                                        <div v-if="pafi">
                                            <md-field>
                                                <label>Valor PaO2/FiO2</label>
                                                <md-input v-model="valorPafi" type="number"></md-input>
                                            </md-field>
                                        </div>
                                        <!-- hasta acá si pafi es true -->
                                    </div>

                                    
                                    <div class="md-layout-item md-small-size-40 md-size-40" >
                                        <md-switch class="md-primary" v-model="pronoVigil">Prono vigil</md-switch>
                                    </div> 
                                    
                                    <div class="md-layout-item md-small-size-40 md-size-40" >
                                        <md-switch class="md-primary" v-model="tos">Tos</md-switch>
                                    </div>

                                    <div class="md-layout-item md-small-size-30 md-size-30" >
                                        <md-field>
                                            <label for="disnea">Disnea</label>
                                            <md-select v-model="disnea" name="disnea">              
                                                <md-option value="0">0</md-option>
                                                <md-option value="1">1</md-option>
                                                <md-option value="2">2</md-option>
                                                <md-option value="3">3</md-option>
                                                <md-option value="4">4</md-option>
                                            </md-select>
                                        </md-field>
                                    </div>

                                    <div class="md-layout-item md-small-size-40 md-size-40" >
                                        <label for="estabilidadDesaparicion">Estabilidad/desaparición de síntomas respiratorios</label>
                                        <md-radio class="md-primary" v-model="estabilidadDesaparicion" :value="true">Sí</md-radio>
                                        <md-radio class="md-primary" v-model="estabilidadDesaparicion" :value="false">No</md-radio>
                                    </div>                                    

                                </div>
                                <!-- hasta acá si requiereO2 es true -->

                            <br>

                        <h4>Otros síntomas</h4>
                       
                            <div class="md-layout-item md-small-size-100 md-size-100">
                                <label for="somnolencia">Somnolencia</label>
                                <div class="md-layout">
                                    <md-radio class="md-primary" v-model="somnolencia" :value="true">Sí</md-radio>
                                    <md-radio class="md-primary" v-model="somnolencia" :value="false">No</md-radio>
                                </div>
                            </div>

                            <div class="md-layout-item md-small-size-100 md-size-100">
                                <label for="anosmia">Anosmia</label>
                                <div class="md-layout">
                                    <md-radio class="md-primary" v-model="anosmia" :value="true">Sí</md-radio>
                                    <md-radio class="md-primary" v-model="anosmia" :value="false">No</md-radio>
                                </div>
                            </div>

                            <div class="md-layout-item md-small-size-100 md-size-100">
                                <label for="disgeusia">Disgeusia</label>
                                <div class="md-layout">
                                    <md-radio class="md-primary" v-model="disgeusia" :value="true">Sí</md-radio>
                                    <md-radio class="md-primary" v-model="disgeusia" :value="false">No</md-radio>
                                </div>
                            </div>

                    </div>

                    <div class="md-layout-item md-small-size-100 md-size-50">

											<h4>Estudios realizados</h4>

											<div class="md-layout-item md-small-size-40 md-size-40" >
												<md-switch class="md-primary" v-model="rxTx">Rx Tx</md-switch>
											</div>
													
											<!-- esto se muestra si rxTx es true -->
											<div class="md-layout-item md-small-size-100 md-size-100" v-show="rxTx">

												<div class="md-layout">
													<md-radio class="md-primary" v-model="rxTxTipo" value="normal">Normal</md-radio>
													<md-radio class="md-primary" v-model="rxTxTipo" value="patológico">Patológico</md-radio>
												</div>

												<div v-show="rxTxTipo == 'patológico'" class="md-layout-item md-small-size-50 md-size-90" >
													<label for="rxTxDescrip">Descripción</label>
													<md-field maxlength="2">
														<md-textarea v-model="rxTxDescrip"></md-textarea>
													</md-field>
												</div>

											</div>
											<!-- hasta acá si rxTx es true -->

											<div class="md-layout-item md-small-size-40 md-size-40" >
												<md-switch class="md-primary" v-model="tacTorax">TAC de tórax</md-switch>
											</div>

											<!-- esto se muestra si tacTorax es true -->
											<div class="md-layout-item md-small-size-100 md-size-100" v-show="tacTorax">

												<div class="md-layout">
													<md-radio class="md-primary" v-model="tacToraxTipo" value="normal">Normal</md-radio>
													<md-radio class="md-primary" v-model="tacToraxTipo" value="patológico">Patológico</md-radio>
												</div>

												<div v-show="tacToraxTipo == 'patológico'" class="md-layout-item md-small-size-50 md-size-90" >
													<label for="tacToraxDescrip">Descripción</label>
													<md-field maxlength="2">
														<md-textarea v-model="tacToraxDescrip"></md-textarea>
													</md-field>
												</div>

											</div>
											<!-- hasta acá si tacTorax es true -->

											<div class="md-layout-item md-small-size-40 md-size-40" >
												<md-switch class="md-primary" v-model="ecg">ECG</md-switch>
											</div>

											<!-- esto se muestra si ecg es true -->
											<div class="md-layout-item md-small-size-100 md-size-100" v-show="ecg">

												<div class="md-layout">
													<md-radio class="md-primary" v-model="ecgTipo" value="normal">Normal</md-radio>
													<md-radio class="md-primary" v-model="ecgTipo" value="patológico">Patológico</md-radio>
												</div>

												<div v-show="ecgTipo == 'patológico'" class="md-layout-item md-small-size-50 md-size-90" >
													<label for="ecgDescrip">Descripción</label>
													<md-field maxlength="2">
														<md-textarea v-model="ecgDescrip"></md-textarea>
													</md-field>
												</div>

											</div>
											<!-- hasta acá si ecg es true -->

											<div class="md-layout-item md-small-size-40 md-size-40" >
												<md-switch class="md-primary" v-model="pcrCovid">PCR Covid</md-switch>
											</div>

                        <!-- esto se muestra si pcrCovid es true -->
											<div class="md-layout-item md-small-size-100 md-size-100" v-show="pcrCovid">
	
												<div class="md-layout">
													<md-radio class="md-primary" v-model="pcrCovidTipo" value="normal">Normal</md-radio>
													<md-radio class="md-primary" v-model="pcrCovidTipo" value="patológico">Patológico</md-radio>
												</div>

												<div v-show="pcrCovidTipo == 'patológico'" class="md-layout-item md-small-size-50 md-size-90" >
													<label for="pcrCovidDescrip">Descripción</label>
													<md-field maxlength="2">
														<md-textarea v-model="pcrCovidDescrip"></md-textarea>
													</md-field>
												</div>

											</div>
											<!-- hasta acá si tacTorax es true -->

											<h4>Observaciones</h4>

											<div class="md-layout-item md-small-size-90 md-size-90" >
												<md-field maxlength="5">
													<md-textarea v-model="observaciones" name="observaciones"></md-textarea>
												</md-field>
											</div>
        
                    </div>
                
									<div class="md-layout-item md-size-100 text-right">
											<md-button class="md-raised md-success" @click="submit()">Guardar</md-button>
									</div>
                </div>
            </md-card-content>
          </md-card>
        </form>
                
    </div>
</template>

<script>
export default {
	data() {
		return {
			temperatura: null,
			taSistolica: null,
			taDiastolica: null,
			frecuenciaCardiaca: null,
			frecuenciaRespiratoria: null,
			mecanicaVentilatoria: null,
			requiereO2: false,
			tipoAdministracionO2: null,
			canulaNasalValor: null,
			mascaraReservorioValor: null,
			satO2: null,
			pafi: false,
			valorPafi: null,
			pronoVigil: false,
			tos: false,
			disnea: null,
			estabilidadDesaparicion: false,
			somnolencia: false,
			anosmia: false,
			disgeusia: false,
			rxTx: false,
			tacTorax: false,
			ecg: false,
			pcrCovid: false,
			rxTxTipo: null,
			rxTxDescrip: null,
			tacToraxTipo: null,
			tacToraxDescrip: null,  
			ecgTipo: null, 
			ecgDescrip: null, 
			pcrCovidTipo: null, 
			pcrCovidDescrip: null,
			observaciones: null
		}
	},
	methods: {
		async submit() {
      events.$emit("loading:show")
			let form = {
				internacion_id: 13,
				temperatura: this.temperatura,
				ta_sistolica: this.taSistolica,
				ta_diastolica: this.taDiastolica,
				frecuencia_cardiaca: this.frecuenciaCardiaca,
				frecuencia_respiratoria: this.frecuenciaRespiratoria,
				mecanica_ventilatoria: this.mecanicaVentilatoria,
				canula_nasal_valor: this.canulaNasalValor,
				mascara_reservorio_valor: this.mascaraReservorioValor,
				saturacion_oxigeno: this.satO2,
				pafi: this.valorPafi,
				prono_vigil: this.pronoVigil,
				tos: this.tos,
				disnea: this.disnea,
				estabilidad_sintomas_respiratorios: this.estabilidadDesaparicion,
				somnolencia: this.somnolencia,
				anosmia: this.anosmia,
				disgeusia: this.disgeusia,
				rx_tx_tipo: this.rxTxTipo,
				rx_tx_descrip: this.rxTxDescrip,
				tac_torax_tipo: this.tacToraxTipo,
				tac_torax_descrip: this.tacToraxDescrip,  
				ecg_tipo: this.ecgTipo, 
				ecg_descrip: this.ecgDescrip, 
				pcr_covid_tipo: this.pcrCovidTipo, 
				pcr_covid_descrip: this.pcrCovidDescrip,
				observaciones: this.observaciones
			}
			const pacientes = await axios.post(this.burl('/api/evolucion/new'), form)
      events.$emit("loading:hide")
		}	
	},
	watch: {
		tipoAdministracionO2(value) {
			if (value == 'Cánula nasal') {
				this.mascaraReservorioValor = null
			} else if (value == 'Máscara con reservorio'){
				this.canulaNasalValor = null
			} else {
				this.mascaraReservorioValor = null
				this.canulaNasalValor = null
			}
		},
		//utilizo estos watchers para limpiar todos los campos asociados a los switch cuando estos se ponen en off.
		requiereO2(value) {
			if (!value) {
				this.satO2 = null
				this.tipoAdministracionO2 = false
				this.canulaNasalValor = null
				this.mascaraReservorioValor = null
				this.pafi = false
				this.valorPafi = null
				this.pronoVigil = false
				this.tos = false
				this.disnea = null
				this.estabilidadDesaparicion = false
			}
		},
		rxTx(value) {
			if (!value) {
				this.rxTxTipo = null
				this.rxTxDescrip = null
			}
		},
		rxTxTipo(value) {
			if (value == "normal") {
				this.rxTxDescrip = null
			}
		},
		tacTorax(value) {
			if (!value) {
				this.tacToraxTipo = null
				this.tacToraxDescrip = null
			}
		},
		tacToraxTipo(value) {
			if (value == "normal") {
				this.tacToraxDescrip = null
			}
		},
		ecg(value) {
			if (!value) {
				this.ecgTipo = null
				this.ecgDescrip = null
			}
		},
		ecgTipo(value) {
			if (value == "normal") {
				this.ecgDescrip = null
			}
		},
		pcrCovid(value) {
			if (!value) {
				this.pcrCovidTipo = null
				this.pcrCovidDescrip = null
			}
		},
		pcrCovidTipo(value) {
			if (value == "normal") {
				this.pcrCovidDescrip = null
			}
		},
	}
}
</script>


<style>
    
</style>