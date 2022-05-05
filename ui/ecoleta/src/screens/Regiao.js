import React, { useState, Component } from 'react';
import { ScrollView, StyleSheet, View } from 'react-native';
import { Text, Button } from 'react-native-elements';
import Icon from 'react-native-vector-icons/FontAwesome';

import api from '../services/api';

export default class Regiao extends Component {
    constructor() {
        super();
    }

    state = {
        regioes: []
    }

    buscaRegioes = async (cityID) => {
        await api.get(`/admin/region/city/${cityID}`).then(response => {
            this.setState({
                regioes: response.data.data.regions
            });
        });
    };

    componentDidMount() {
        this.buscaRegioes(this.props.route.params.cityID);
    }

    render() {
        const regioes = this.state.regioes.map((value, index) => {
            return { name: value.title, value: value.id, key: value.id }
        });

        const pontosDeColeta = (pontoID) => {
            if (pontoID)
                this.props.navigation.navigate('Pontos de Coleta', { pontoID });
        }

        return (
            <View style={styles.container} >
                <Button
                    style={{
                        width: 60,
                        marginLeft: 350
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

                <Text h3>Regiões</Text>

                <ScrollView>
                    {regioes.map(item => (
                        <View key={item.key}>
                            <Text
                                style={styles.item}
                                onPress={() => pontosDeColeta(item.key)}
                            >{item.name}</Text>
                        </View>
                    ))
                    }
                </ScrollView>
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
});