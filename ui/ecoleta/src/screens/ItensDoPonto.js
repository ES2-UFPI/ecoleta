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
        pontoDeColetaTitle: '',
        pontoDeColetaID: '',
        modalVisible: false,
        itensParaDescarte: [],
        itensParaDescarteSelecionado: [],
        itemSelecionadoNome: '',
        itemSelecionadoID: ''
    }

    buscaItensDoPonto = async (pontoDeColetaTitle, itemID) => {
        await api.get(`/admin/collectionItem/collectPoint/${itemID}`).then(response => {
            this.setState({
                itens: response.data.data.collectionItems,
                pontoDeColetaTitle: pontoDeColetaTitle
            });
        });
    };

    componentDidMount() {
        const { pontoDeColetaTitle, itemID } = this.props.route.params;
        this.buscaItensDoPonto(pontoDeColetaTitle, itemID);
    }

    setModalVisible = (visible, nome, id, armazenar) => {
        if (armazenar && this.state.itensParaDescarteSelecionado.quantidade !== undefined) {
            if (!this.state.itensParaDescarte.find(element => element.item === this.state.itemSelecionadoID))
                this.state.itensParaDescarte.push(this.state.itensParaDescarteSelecionado);
            else {
                const index = this.state.itensParaDescarte.findIndex(element => element.item === this.state.itemSelecionadoID)
                this.state.itensParaDescarte[index].quantidade = this.state.itensParaDescarteSelecionado.quantidade;
            }

            this.setState({
                itensParaDescarteSelecionado: []
            });
        }

        this.setState({
            modalVisible: visible,
            itemSelecionadoNome: nome,
            itemSelecionadoID: id
        });
    }

    render() {
        const itens = this.state.itens.map((value, index) => {
            return { name: value.title, value: value.id, key: value.id }
        });

        const sacolaDeDescarte = () => {
            console.log('realizando descarte...', this.state.itensParaDescarteSelecionado, this.state.itensParaDescarte)
        }

        const setaItem = (nome, item, quantidade) => {
            this.setState({
                itensParaDescarteSelecionado: { nome: nome, item: item, quantidade: quantidade }
            });
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
                <Text h6 style={{ textAlign: 'center' }}>Escolha os itens que deseja descartar e informe a quantidade presionando em cada item da lista.</Text>
                <ScrollView>
                    {itens.map(item => (
                        <View key={item.key}>
                            <Text
                                style={styles.item}
                                onPress={() => this.setModalVisible(true, item.name, item.key, false)}
                            >{item.name} - {item.key} - Qtd.: 0</Text>
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
                        this.setModalVisible(!modalVisible, '', '', false);
                    }}
                >
                    <View style={styles.centeredView}>
                        <View style={styles.modalView}>
                            <Text style={styles.modalText}>{this.state.itemSelecionadoNome}</Text>
                            <Input
                                keyboardType='numeric'
                                style={{ width: 300 }}
                                placeholder='Quantidade'
                                onChangeText={(value) => setaItem(this.state.itemSelecionadoNome, this.state.itemSelecionadoID, value)}
                            />
                            <Pressable
                                style={[styles.button, styles.buttonClose]}
                                onPress={() => this.setModalVisible(!modalVisible, '', '', true)}
                            >
                                <Text style={styles.textStyle}>Confirmar</Text>
                            </Pressable>
                            <Pressable
                                style={[styles.button, styles.buttonDelete]}
                                onPress={() => this.setModalVisible(!modalVisible, '', '', false)}
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