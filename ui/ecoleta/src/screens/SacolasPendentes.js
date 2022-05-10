import React, { useState, Component } from 'react';
import { Alert, BackHandler, ScrollView, StyleSheet, View } from 'react-native';
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
        this._unsubscribe = this.props.navigation.addListener('focus', () => {
            console.log('Atualizando tela SacolasPendentes');
            const { pontoDeColetaId } = this.props.route.params;
            this.buscaSacolasPendentes(pontoDeColetaId);
        });
    }

    componentWillUnmount() {
        this._unsubscribe();
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
                Alert.alert('Cadastro do resgate da sacola realizada com sucesso!');
                this.props.navigation.navigate('Resgate de Sacolas Pendentes');
            });
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

                <Text h3>Sacolas:</Text>
                <Text h5>Selecione uma sacola para realizar o resgate.</Text>

                <ScrollView>
                    {this.state.bags.map(bag => (
                        <View key={bag.id}>
                            <Text
                                style={styles.item}
                                onPress={() => resgatarSacola(bag.id)}
                            >
                                #Sacola {bag.id}
                            </Text>
                            <Text h5>
                            {bag.item.map(item => {
                                    return item.collectionItem.title + ` (${item.quantity} itens) , `
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