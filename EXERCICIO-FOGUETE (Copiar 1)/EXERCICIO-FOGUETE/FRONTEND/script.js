/* =========================================================
   MISSION: LUNA — lógica do frontend
   Este arquivo NÃO altera o backend. Ele só envia os dados
   por POST e interpreta o texto/HTML que o processar.php
   já devolve hoje.
   ========================================================= */

// ---- constantes da missão (mesmos valores usados no backend) ----
const DISTANCIA_TOTAL = 384400;
const DISTANCIA_TRECHO = 15376;
const TOTAL_TRECHOS = 25; // 384400 / 15376

// ---- elementos da página ----
const form = document.getElementById('missionForm');
const inputCombustivel = document.getElementById('combustivel');
const inputConsumo = document.getElementById('consumo');
const errCombustivel = document.getElementById('errCombustivel');
const errConsumo = document.getElementById('errConsumo');
const launchBtn = document.getElementById('launchBtn');

const trackProgress = document.getElementById('trackProgress');
const rocket = document.getElementById('rocket');
const rocketFlame = document.getElementById('rocketFlame');
const progressBar = document.getElementById('progressBar');
const progressValue = document.getElementById('progressValue');
const phaseTag = document.getElementById('phaseTag');
const telemetryTag = document.getElementById('telemetryTag');

const countdownOverlay = document.getElementById('countdownOverlay');
const countdownNumber = document.getElementById('countdownNumber');
const resultOverlay = document.getElementById('resultOverlay');
const resultIcon = document.getElementById('resultIcon');
const resultTitle = document.getElementById('resultTitle');
const resultSub = document.getElementById('resultSub');

const teleInicial = document.getElementById('teleInicial');
const teleAtual = document.getElementById('teleAtual');
const teleConsumido = document.getElementById('teleConsumido');
const teleDistPercorrida = document.getElementById('teleDistPercorrida');
const teleDistRestante = document.getElementById('teleDistRestante');
const teleProgresso = document.getElementById('teleProgresso');
const teleTrecho = document.getElementById('teleTrecho');
const teleStatus = document.getElementById('teleStatus');

const historyBody = document.getElementById('historyBody');
const clockEl = document.getElementById('clock');

// ---- gráfico (Chart.js) ----
let fuelChart = null;

// =========================================================
// CAMPO DE ESTRELAS (apenas decorativo)
// =========================================================
function criarEstrelas() {
  const field = document.getElementById('starfield');
  const total = 90;
  for (let i = 0; i < total; i++) {
    const star = document.createElement('div');
    star.className = 'star';
    const size = Math.random() * 2 + 1;
    star.style.width = size + 'px';
    star.style.height = size + 'px';
    star.style.top = Math.random() * 100 + 'vh';
    star.style.left = Math.random() * 100 + 'vw';
    star.style.animationDuration = (Math.random() * 6 + 6) + 's, ' + (Math.random() * 3 + 2) + 's';
    star.style.animationName = 'drift, twinkle';
    star.style.animationIterationCount = 'infinite, infinite';
    star.style.animationDelay = '-' + Math.random() * 6 + 's';
    field.appendChild(star);
  }
}

// =========================================================
// RELÓGIO NO CABEÇALHO (apenas decorativo)
// =========================================================
function atualizarRelogio() {
  const agora = new Date();
  clockEl.textContent = agora.toLocaleTimeString('pt-BR', { hour12: false });
}

// =========================================================
// VALIDAÇÃO DO FORMULÁRIO
// =========================================================
function validarCampos() {
  let valido = true;

  errCombustivel.textContent = '';
  errConsumo.textContent = '';
  inputCombustivel.parentElement.parentElement.classList.remove('has-error');
  inputConsumo.parentElement.parentElement.classList.remove('has-error');

  const combustivel = inputCombustivel.value.trim();
  const consumo = inputConsumo.value.trim();

  if (combustivel === '') {
    errCombustivel.textContent = 'Informe a quantidade de combustível.';
    inputCombustivel.closest('.field').classList.add('has-error');
    valido = false;
  } else if (isNaN(combustivel) || Number(combustivel) <= 0) {
    errCombustivel.textContent = 'Use um número maior que zero.';
    inputCombustivel.closest('.field').classList.add('has-error');
    valido = false;
  }

  if (consumo === '') {
    errConsumo.textContent = 'Informe o consumo por trecho.';
    inputConsumo.closest('.field').classList.add('has-error');
    valido = false;
  } else if (isNaN(consumo) || Number(consumo) <= 0) {
    errConsumo.textContent = 'Use um número maior que zero.';
    inputConsumo.closest('.field').classList.add('has-error');
    valido = false;
  }

  return valido;
}

// =========================================================
// ENVIO AO BACKEND (POST para ../BACKEND/processar.php)
// =========================================================
async function enviarParaBackend(combustivel, consumo) {
  const dados = new FormData();
  dados.append('combustivel', combustivel);
  dados.append('consumo', consumo);

  const resposta = await fetch('../BACKEND/processar.php', {
    method: 'POST',
    body: dados
  });

  return await resposta.text();
}

// =========================================================
// INTERPRETAÇÃO DA RESPOSTA DO BACKEND
// O backend devolve HTML/texto solto, por exemplo:
//   <li>Combustível no tanque = 97 || Distância =15376<br>
// ou, em caso de falta de combustível:
//   Faltaram 200 para chegar à Lua.
// Aqui o JS extrai desses textos os números que interessam.
// =========================================================
function interpretarResposta(texto) {
  const resultado = {
    sucesso: false,
    trechos: [],      // [{ distancia, combustivel }]
    faltou: null       // número informado pelo backend, se houver
  };

  // Cada trecho bem-sucedido aparece como:
  // "tanque = <numero> || Dist[a/â]ncia =<numero>"
  // O "." no meio de "Dist.ncia" tolera qualquer variação de acentuação/encoding.
  const regexTrecho = /tanque\s*=\s*(-?[\d.,]+)\s*\|\|\s*Dist.ncia\s*=\s*([\d.,]+)/gi;

  let match;
  while ((match = regexTrecho.exec(texto)) !== null) {
    resultado.trechos.push({
      combustivel: parseFloat(match[1].replace(',', '.')),
      distancia: parseFloat(match[2].replace(',', '.'))
    });
  }

  if (/Faltaram/i.test(texto)) {
    const regexFalta = /Faltaram\s+(-?[\d.,]+)/i;
    const m = texto.match(regexFalta);
    if (m) resultado.faltou = parseFloat(m[1].replace(',', '.'));
    resultado.sucesso = false;
  } else if (resultado.trechos.length > 0) {
    resultado.sucesso = true;
  }

  return resultado;
}

// =========================================================
// FORMATAÇÃO
// =========================================================
function fmt(numero) {
  return Number(numero).toLocaleString('pt-BR', { maximumFractionDigits: 2 });
}

function fmtKm(numero) {
  return fmt(numero) + ' km';
}

// =========================================================
// CONTAGEM REGRESSIVA
// =========================================================
function contagemRegressiva() {
  return new Promise((resolve) => {
    const passos = ['3', '2', '1', 'LIFTOFF'];
    let i = 0;

    countdownOverlay.classList.add('visible');

    function proximoPasso() {
      countdownNumber.textContent = passos[i];
      countdownNumber.style.animation = 'none';
      // força reinício da animação
      void countdownNumber.offsetWidth;
      countdownNumber.style.animation = 'countPop 0.9s ease';

      i++;
      if (i < passos.length) {
        setTimeout(proximoPasso, 600);
      } else {
        setTimeout(() => {
          countdownOverlay.classList.remove('visible');
          resolve();
        }, 500);
      }
    }
    proximoPasso();
  });
}

// =========================================================
// ANIMAÇÃO DA SIMULAÇÃO, TRECHO A TRECHO
// =========================================================
async function animarTrechos(trechos, combustivelInicial, sucesso) {
  historyBody.innerHTML = '';
  const graficoDistancias = [];
  const graficoCombustivel = [];

  rocketFlame.classList.add('active');
  phaseTag.textContent = 'Missão em andamento';
  telemetryTag.textContent = 'Recebendo dados';

  for (let i = 0; i < trechos.length; i++) {
    const trecho = trechos[i];
    const progresso = Math.min(trecho.distancia / DISTANCIA_TOTAL, 1);

    // trilho e barra de progresso
    trackProgress.style.width = (progresso * 100) + '%';
    rocket.style.left = (progresso * 100) + '%';
    progressBar.style.width = (progresso * 100) + '%';
    progressValue.textContent = Math.round(progresso * 100) + '%';

    // cards de telemetria
    teleAtual.textContent = fmt(trecho.combustivel);
    teleConsumido.textContent = fmt(combustivelInicial - trecho.combustivel);
    teleDistPercorrida.textContent = fmtKm(trecho.distancia);
    teleDistRestante.textContent = fmtKm(Math.max(DISTANCIA_TOTAL - trecho.distancia, 0));
    teleProgresso.textContent = Math.round(progresso * 100) + '%';
    teleTrecho.textContent = (i + 1) + ' / ' + TOTAL_TRECHOS;

    // linha da tabela de histórico
    const linha = document.createElement('tr');
    linha.className = 'new-row';
    linha.innerHTML =
      '<td>' + String(i + 1).padStart(2, '0') + '</td>' +
      '<td>' + fmtKm(trecho.distancia) + '</td>' +
      '<td>' + fmt(trecho.combustivel) + '</td>';
    historyBody.appendChild(linha);
    historyBody.parentElement.parentElement.scrollTop = historyBody.parentElement.parentElement.scrollHeight;

    // gráfico
    graficoDistancias.push(fmtKm(trecho.distancia));
    graficoCombustivel.push(trecho.combustivel);
    atualizarGrafico(graficoDistancias, graficoCombustivel);

    await esperar(sucesso ? 90 : 140);
  }

  rocketFlame.classList.remove('active');
}

function esperar(ms) {
  return new Promise((resolve) => setTimeout(resolve, ms));
}

// =========================================================
// GRÁFICO DE COMBUSTÍVEL POR TRECHO (Chart.js)
// =========================================================
function inicializarGrafico() {
  const ctx = document.getElementById('fuelChart').getContext('2d');
  fuelChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [],
      datasets: [{
        label: 'Combustível restante',
        data: [],
        borderColor: '#4fd8eb',
        backgroundColor: 'rgba(79,216,235,0.12)',
        tension: 0.25,
        fill: true,
        pointRadius: 2,
        pointBackgroundColor: '#f5a623'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: { duration: 200 },
      scales: {
        x: {
          ticks: { color: '#7c8aa0', font: { family: 'IBM Plex Mono', size: 10 } },
          grid: { color: 'rgba(255,255,255,0.05)' }
        },
        y: {
          ticks: { color: '#7c8aa0', font: { family: 'IBM Plex Mono', size: 10 } },
          grid: { color: 'rgba(255,255,255,0.05)' }
        }
      },
      plugins: {
        legend: { display: false }
      }
    }
  });
}

function atualizarGrafico(labels, dados) {
  fuelChart.data.labels = labels;
  fuelChart.data.datasets[0].data = dados;
  fuelChart.update();
}

// =========================================================
// TELA FINAL DA MISSÃO
// =========================================================
function mostrarResultado(sucesso, faltou) {
  resultOverlay.classList.remove('success', 'fail');

  if (sucesso) {
    resultOverlay.classList.add('success');
    resultIcon.textContent = '🌕';
    resultTitle.textContent = 'MISSION COMPLETE';
    resultSub.textContent = 'Foguete chegou à Lua';
    phaseTag.textContent = 'Missão concluída';
    telemetryTag.textContent = 'Missão concluída';
    teleStatus.textContent = 'Sucesso';
    teleStatus.className = 'tele-value ok';
  } else {
    resultOverlay.classList.add('fail');
    resultIcon.textContent = '⚠️';
    resultTitle.textContent = 'MISSION ABORTED';
    resultSub.textContent = 'Combustível insuficiente' +
      (faltou !== null ? ' — faltaram ' + fmt(faltou) + ' unidades' : '');
    phaseTag.textContent = 'Missão abortada';
    telemetryTag.textContent = 'Missão abortada';
    teleStatus.textContent = 'Falha';
    teleStatus.className = 'tele-value danger';
  }

  resultOverlay.classList.add('visible');
}

function esconderResultado() {
  resultOverlay.classList.remove('visible', 'success', 'fail');
}

// =========================================================
// FLUXO PRINCIPAL AO SUBMETER O FORMULÁRIO
// =========================================================
form.addEventListener('submit', async (evento) => {
  evento.preventDefault();

  if (!validarCampos()) return;

  const combustivel = Number(inputCombustivel.value);
  const consumo = Number(inputConsumo.value);

  // reset visual antes de uma nova simulação
  esconderResultado();
  trackProgress.style.width = '0%';
  rocket.style.left = '0%';
  progressBar.style.width = '0%';
  progressValue.textContent = '0%';
  historyBody.innerHTML = '';
  teleInicial.textContent = fmt(combustivel);
  teleAtual.textContent = fmt(combustivel);
  teleConsumido.textContent = '0';
  teleDistPercorrida.textContent = '0 km';
  teleDistRestante.textContent = fmtKm(DISTANCIA_TOTAL);
  teleProgresso.textContent = '0%';
  teleTrecho.textContent = '0 / ' + TOTAL_TRECHOS;
  teleStatus.textContent = 'Em voo';
  teleStatus.className = 'tele-value warn';

  launchBtn.disabled = true;
  launchBtn.textContent = 'MISSÃO EM ANDAMENTO...';

  try {
    await contagemRegressiva();

    const textoResposta = await enviarParaBackend(combustivel, consumo);
    const dados = interpretarResposta(textoResposta);

    if (dados.trechos.length === 0 && dados.faltou === null) {
      // resposta do backend veio em formato inesperado
      teleStatus.textContent = 'Resposta inválida do backend';
      teleStatus.className = 'tele-value danger';
    } else {
      await animarTrechos(dados.trechos, combustivel, dados.sucesso);
      mostrarResultado(dados.sucesso, dados.faltou);
    }
  } catch (erro) {
    teleStatus.textContent = 'Erro de comunicação';
    teleStatus.className = 'tele-value danger';
    console.error('Falha ao comunicar com o backend:', erro);
  } finally {
    launchBtn.disabled = false;
    launchBtn.textContent = '🚀 ACIONAR FOGUETE';
  }
});

// =========================================================
// INICIALIZAÇÃO
// =========================================================
criarEstrelas();
inicializarGrafico();
atualizarRelogio();
setInterval(atualizarRelogio, 1000);