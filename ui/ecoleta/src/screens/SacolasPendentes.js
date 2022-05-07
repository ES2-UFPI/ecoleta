import React, { useState, Component } from 'react';
import { BackHandler, ScrollView, StyleSheet, View } from 'react-native';
import { Text, Button } from 'react-native-elements';
import Icon from 'react-native-vector-icons/FontAwesome';

import api from '../services/api';

export default class SacolasPendentes extends Component {
    constructor() {
        super();
    }

    state = {
        pontoDeColetaId: '',
        bags: []
    }

    buscaSacolasPendentes = async (pontoDeColetaId) => {
        await api.get(`/admin/bags/finished/${pontoDeColetaId}`).then(response => {
            this.setState({
                bags: response.data.data.bags,
            });
        });
    };

    componentDidMount() {
        const { pontoDeColetaId } = this.props.route.params;
        this.buscaSacolasPendentes(pontoDeColetaId);
    }

    render() {

        const resgatarSacola = async (bag_id) => {
            const body = {
                company_id: 2,
                bag_id: bag_id
            }
            console.log(body)
            await api.post(`/admin/bag-rescue`, body).then(response => {
                console.log('cadastro do resgate da sacola realizada com sucesso!');
                this.props.navigation.navigate('Resgate de Sacolas Pendentes');
            });
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

                <Text h3>Sacolas:</Text>
                <Text h6>Itens (qtd. do item na sacola)</Text>

                <ScrollView>
                    {this.state.bags.map(bag => (
                        <View key={bag.id}>
                            <Text
                                style={styles.item}
                                onPress={() => resgatarSacola(bag.id)}
                            >
                                {bag.item.map(item => {
                                    return item.collectionItem.title + ` (${item.quantity}) , `
                                })}
                            </Text>
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