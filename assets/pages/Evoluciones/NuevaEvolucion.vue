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

                                    <div class="md-layout-item md-small-size-50 md-size-50" >
                                        <md-field>
                                            <label for="tipoAdministracionO2">Tipo Administración O2</label>
                                            <md-select v-model="tipoAdministracionO2" name="tipoAdministracionO2">              
                                                <md-option value="Cánula nasal">Cánula nasal de oxígeno</md-option>
                                                <md-option value="Mascara con reservorio">Máscara con reservorio</md-option>
                                            </md-select>
                                        </md-field>
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
                                        <md-radio class="md-success" v-model="estabilidadDesaparicion" :value="false">Sí</md-radio>
                                        <md-radio v-model="estabilidadDesaparicion" :value="true">No</md-radio>
                                    </div>                                    

                                </div>
                                <!-- hasta acá si requiereO2 es true -->

                            <br>

                        <h4>Otros síntomas</h4>
                       
                            <div class="md-layout-item md-small-size-100 md-size-100">
                                <label for="somnolencia">Somnolencia</label>
                                <div class="md-layout">
                                    <md-radio v-model="somnolencia" :value="false">Sí</md-radio>
                                    <md-radio v-model="somnolencia" :true="true">No</md-radio>
                                </div>
                            </div>

                            <div class="md-layout-item md-small-size-100 md-size-100">
                                <label for="disgeusia">Anosmia</label>
                                <div class="md-layout">
                                    <md-radio v-model="anosmia" :value="false">Sí</md-radio>
                                    <md-radio v-model="anosmia" :true="true">No</md-radio>
                                </div>
                            </div>

                            <div class="md-layout-item md-small-size-100 md-size-100">
                                <label for="disgeusia">Disgeusia</label>
                                <div class="md-layout">
                                    <md-radio v-model="disgeusia" :value="false">Sí</md-radio>
                                    <md-radio v-model="disgeusia" :true="true">No</md-radio>
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
                                <md-radio v-model="rxTxTipo" value="normal">Normal</md-radio>
                                <md-radio v-model="rxTxTipo" value="patológico">Patológico</md-radio>
                            </div>

                            <div class="md-layout-item md-small-size-50 md-size-90" >
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
                                <md-radio v-model="tacToraxTipo" value="normal">Normal</md-radio>
                                <md-radio v-model="tacToraxTipo" value="patológico">Patológico</md-radio>
                            </div>

                            <div class="md-layout-item md-small-size-50 md-size-90" >
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
                                <md-radio v-model="ecgTipo" value="normal">Normal</md-radio>
                                <md-radio v-model="ecgTipo" value="patológico">Patológico</md-radio>
                            </div>

                            <div class="md-layout-item md-small-size-50 md-size-90" >
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
                                <md-radio v-model="pcrCovidTipo" value="normal">Normal</md-radio>
                                <md-radio v-model="pcrCovidTipo" value="patológico">Patológico</md-radio>
                            </div>

                            <div class="md-layout-item md-small-size-50 md-size-90" >
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
                    <md-button class="md-raised md-success">Guardar</md-button>
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
            rxTxTipo: false,
            rxTxDescrip: null,
            tacToraxTipo: false,
            tacToraxDescrip: null,  
            ecgTipo: false, 
            ecgDescrip: null, 
            pcrCovidTipo: false, 
            pcrCovidDescrip: null,
            observaciones: null
        }
    },
    methods: {

    }
}
</script>


<style>
    
</style>