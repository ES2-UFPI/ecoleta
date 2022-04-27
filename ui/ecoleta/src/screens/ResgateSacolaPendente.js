import React, { useState, Component } from 'react';
import { ScrollView, StyleSheet, View } from 'react-native';
import { Text, Button } from 'react-native-elements';
import Icon from 'react-native-vector-icons/FontAwesome';

import api from '../services/api';

export default class ResgateSacolaPendente extends Component {
    constructor() {
        super();
    }

    state = {
        resgateDeSacolasPendentes: []
    }

    buscaresgateDeSacolasPendentes = async () => {
        await api.get(`/admin/bag-rescue/rescues/pending`).then(response => {
            this.setState({
                resgateDeSacolasPendentes: response.data.data.bags
            });
        });
    };

    componentDidMount() {
        this.buscaresgateDeSacolasPendentes();
    }

    render() {
        const sacolas = this.state.resgateDeSacolasPendentes.map((value, index) => {
            return { name: value.bag.collect_point.title, value: value.bag.collect_point.id, key: value.bag.collect_point.id }
        });

        console.log(sacolas)

        const verSacola = () => {
            console.log('ver resgate de sacola pendente')
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

                <ScrollView>
                    {sacolas.map(item => (
                        <View key={item.key}>
                            <Text
                                style={styles.item}
                                onPress={() => verSacola(item.key)}
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