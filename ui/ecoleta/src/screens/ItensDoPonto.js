import React, { useState, Component } from 'react';
import { StyleSheet, View, ScrollView, Alert, Modal, Pressable } from 'react-native';
import { Text, Image, Button, Overlay, Input } from 'react-native-elements';
import Icon from 'react-native-vector-icons/FontAwesome';

import api from '../services/api';

export default class ItensDoPonto extends Component {
    constructor() {
        super();
    }

    state = {
        itens: [],
        pontoDeColetaID: '',
        pontoDeColetaTitle: '',
        modalVisible: false,
        itemTitle: '',
        itemQtd: 0,
        itemSelected: {},
        itensBag: []
    }

    buscaItensDoPonto = async (pontoDeColetaTitle, itemID) => {
        await api.get(`/admin/collectionItem/collectPoint/${itemID}`).then(response => {
            this.setState({
                itens: response.data.data.collectionItems,
                pontoDeColetaID: itemID,
                pontoDeColetaTitle: pontoDeColetaTitle
            });
        });
    };

    componentDidMount() {
        const { pontoDeColetaTitle, itemID } = this.props.route.params;
        this.buscaItensDoPonto(pontoDeColetaTitle, itemID);
    }

    setModalVisible = (visible, item, qtd, update, destroy) => {
        const itemBag = this.state.itensBag.filter(itemSelected => itemSelected.key === item.key);
        if (!itemBag.length) {
            this.state.itensBag.push(item);
        }

        if (update) {
            const itensBag = this.state.itensBag.filter(itemSelected => itemSelected.key !== item.key);
            this.state.itensBag = itensBag;
            this.state.itensBag.push({
                key: item.key,
                name: item.name,
                value: qtd
            });
        }

        if (destroy) {
            const itensBag = this.state.itensBag.filter(itemSelected => itemSelected.key !== item.key);
            this.state.itensBag = itensBag;
        }

        this.state.itemSelected = item;

        this.setState({
            modalVisible: visible,
            itemTitle: item.name,
            itemQtd: 0,
        });
    }

    render() {
        const itens = this.state.itens.map((value, index) => {
            return { name: value.title, value: value.id, key: value.id }
        });

        const sacolaDeDescarte = async () => {
            if (!this.state.itensBag.length) {
                console.log('Selecione pelo menos um item.')
                return;
            }

            const items = this.state.itensBag.map(item => {
                return item.key
            });

            const quantities = this.state.itensBag.map(item => {
                return item.value
            });

            const body = {
                user_id: 1,
                collect_point_id: this.state.pontoDeColetaID,
                item: items,
                quantity: quantities
            };

            await api.post(`/admin/bag`, body).then(response => {
                console.log('cadastro de sacola realizada com sucesso!');
                this.props.navigation.navigate('Sacolas Pendentes');
            });

            // console.log('\n---inicio---', this.state.itensBag, '\n---fim---')
        }

        const resgateDeSacolas = () => {
            console.log('realizar resgate de sacolas');
            this.props.navigation.navigate('Sacolas Pendentes', {pontoDeColetaId: this.state.pontoDeColetaID});
        }

        const { modalVisible } = this.state;

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

                <Image
                    source={require('../../assets/recycle.jpg')}
                    style={{ width: 200, height: 200, marginTop: 20 }}
                />

                <Text h1>{this.state.pontoDeColetaTitle}</Text>
                <Text h4>Itens do Ponto de Coleta:</Text>
                <Text h6 style={{ textAlign: 'center' }}>Escolha os itens que deseja descartar e informe a quantidade selecionando um item da lista.</Text>
                <ScrollView>
                    {itens.map(item => (
                        <View key={item.key}>
                            <Text
                                style={styles.item}
                                onPress={() => this.setModalVisible(true, item, 0, false, false)}
                            >{item.name} - Qtd.: 0</Text>
                        </View>
                    ))
                    }
                </ScrollView>

                <Modal
                    animationType="slide"
                    transparent={true}
                    visible={modalVisible}
                    onRequestClose={() => {
                        Alert.alert("Modal has been closed.");
                        this.setModalVisible(!modalVisible, '', 0, false, false);
                    }}
                >
                    <View style={styles.centeredView}>
                        <View style={styles.modalView}>
                            <Text style={styles.modalText}>{this.state.itemTitle}</Text>
                            <Input
                                style={{ width: 300 }}
                                keyboardType="numeric"
                                placeholder='Quantidade'
                                onChangeText={(value) => this.setState({ itemQtd: value })}
                            />
                            <Pressable
                                style={[styles.button, styles.buttonClose]}
                                onPress={() => this.setModalVisible(!modalVisible, this.state.itemSelected, this.state.itemQtd, true, false)}
                            >
                                <Text style={styles.textStyle}>Confirmar</Text>
                            </Pressable>
                            <Pressable
                                style={[styles.button, styles.buttonDelete]}
                                onPress={() => this.setModalVisible(!modalVisible, this.state.itemSelected, 0, false, true)}
                            >
                                <Text style={styles.textStyle}>Apagar</Text>
                            </Pressable>
                        </View>
                    </View>
                </Modal>

                <Button
                    title=' Realizar Descarte'
                    icon={
                        <Icon
                            name='trash'
                            size={15}
                            color='blue'
                        />
                    }
                    onPress={() => sacolaDeDescarte()}
                />

                <Button
                    title=' Realizar Coleta'
                    icon={
                        <Icon
                            name='eye'
                            size={15}
                            color='blue'
                        />
                    }
                    onPress={() => resgateDeSacolas()}
                />
            </View>
        );
    }
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: '#fff',
        alignItems: 'center',
        justifyContent: 'center',
    },

    item: {
        padding: 10,
        margin: 5,
        fontSize: 16,
        width: 300,
        backgroundColor: '#eee',
    },

    centeredView: {
        flex: 1,
        justifyContent: "center",
        alignItems: "center",
        marginTop: 22
    },
    modalView: {
        width: 300,
        margin: 20,
        backgroundColor: "white",
        borderRadius: 20,
        padding: 35,
        alignItems: "center",
        shadowColor: "#000",
        shadowOffset: {
            width: 0,
            height: 2
        },
        shadowOpacity: 0.25,
        shadowRadius: 4,
        elevation: 5
    },
    button: {
        borderRadius: 20,
        padding: 10,
        elevation: 2
    },
    buttonOpen: {
        backgroundColor: "#F194FF",
    },
    buttonClose: {
        width: 200,
        backgroundColor: "#2196F3",
    },
    buttonDelete: {
        marginTop: 10,
        width: 200,
        backgroundColor: "#C85E34",
    },
    textStyle: {
        color: "white",
        fontWeight: "bold",
        textAlign: "center"
    },
    modalText: {
        marginBottom: 15,
        textAlign: "center"
    }
});