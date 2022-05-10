import React, { useState, Component } from 'react';
import MapView, { Marker, Callout } from 'react-native-maps';
import { ScrollView, StyleSheet, View, Dimensions } from 'react-native';
import { Text, Button } from 'react-native-elements';
import Icon from 'react-native-vector-icons/FontAwesome';

import api from '../services/api';

export default class PontoDeColeta extends Component {
    constructor() {
        super();
    }

    state = {
        latitudeInit: -5.05296,
        longitudeInit: -42.79038,
        pontosDeColeta: []
    }

    buscaPontosDeColeta = async (pontoID) => {
        await api.get(`/admin/collect_point/region/${pontoID}`).then(response => {
            this.setState({
                pontosDeColeta: response.data.data.collectPoints
            });
        });
    };

    componentDidMount() {
        this._unsubscribe = this.props.navigation.addListener('focus', () => {
            console.log('Atualizando tela PontoDeColeta');
            this.buscaPontosDeColeta(this.props.route.params.pontoID);
        });
    }

    componentWillUnmount() {
        this._unsubscribe();
    }

    render() {
        const pontos = this.state.pontosDeColeta.map((value, index) => {
            if (index === 0) {
                this.state.latitudeInit = parseFloat(value.latitude);
                this.state.longitudeInit = parseFloat(value.longitude);
            }

            return { name: value.title, value: value.id, key: value.id, latitude: value.latitude, longitude: value.longitude }
        });

        const itensDoPontoDeColeta = (pontoDeColetaTitle, itemID) => {
            if (itemID)
                this.props.navigation.navigate('Itens do Ponto', { pontoDeColetaTitle, itemID });
        }

        return (
            <View style={styles.container} >
                <Button
                    title=' Voltar'
                    containerStyle={{
                        width: '100%', marginLeft: 0
                    }}
                    icon={
                        <Icon
                            name='arrow-left'
                            size={15}
                            color='blue'
                        />
                    }
                    onPress={() => this.props.navigation.goBack()}
                />

                <Text h3>Pontos de coleta</Text>
                <Text h5>Veja no mapa abaixo os pontos de coleta.</Text>

                {/* <ScrollView>
                    {pontos.map(item => (
                        <View key={item.key}>
                            <Text
                                style={styles.item}
                                onPress={() => itensDoPontoDeColeta(item.name, item.key)}
                            >{item.name}</Text>
                        </View>
                    ))
                    }
                </ScrollView> */}



                <MapView
                    style={styles.map}
                    region={{
                        latitude: this.state.latitudeInit,
                        longitude: this.state.longitudeInit,
                        latitudeDelta: 0.05,
                        longitudeDelta: 0.05,
                    }}
                >
                    {pontos.map(item => (
                        <Marker
                            key={item.key}
                            coordinate={{
                                latitude: parseFloat(item.latitude),
                                longitude: parseFloat(item.longitude)
                            }}
                            title={item.name}
                            description={item.name}
                        >
                            <Button
                                icon={
                                    <Icon
                                        name='recycle'
                                        size={15}
                                        color='white'
                                        backgroundColor='green'
                                    />
                                }
                            />
                            <Callout
                                onPress={() => itensDoPontoDeColeta(item.name, item.key)}
                            >
                            </Callout>
                        </Marker>
                    ))}
                </MapView>
            </View>
        );
    }
}

const styles = StyleSheet.create({
    item: {
        padding: 10,
        margin: 5,
        fontSize: 20,
        backgroundColor: '#eee',
    },
    map: {
        width: Dimensions.get('window').width,
        height: Dimensions.get('window').height,
    },
});